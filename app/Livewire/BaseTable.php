<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class BaseTable extends Component
{
    use WithPagination;

    public $model;
    public $columns = [];
    public $actions = [];
    public $search = '';
    public $filter = [];
    public $sortField;
    public $sortDirection = 'asc';
    public $primaryKey;
    public $constantFilter = [];
    public $constantFilterNot = [];
    public $sortableRelations = [];
    public $searchableRelations = [];
    public $perPage = 10;
    public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function mount($model, $columns = [], $actions = [], $primaryKey = 'id', $sortableRelations = [], $searchableRelations = [], $perPage = 10)
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->actions = $actions;
        $this->primaryKey = $primaryKey;
        $this->sortField = $primaryKey;
        $this->sortableRelations = $sortableRelations;
        $this->searchableRelations = $searchableRelations;
        $this->perPage = $perPage;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function previousPage()
    {
        $this->setPage(max($this->getPage() - 1, 1));
    }

    public function nextPage()
    {
        $items = $this->getPaginationItems();
        $this->setPage(min($this->getPage() + 1, $items->lastPage()));
    }

    public function getPage()
    {
        return $this->paginators['page'] ?? 1;
    }

    protected function getPaginationItems()
    {
        // This is a helper method to get the pagination without rendering the full view
        $model = new $this->model;
        $query = $model->newQuery();

        // Apply basic filtering just to get pagination info
        if (!empty($this->constantFilter)) {
            foreach ($this->constantFilter as $field => $value) {
                $query->where($field, $value);
            }
        }

        if (!empty($this->constantFilterNot)) {
            foreach ($this->constantFilterNot as $field => $value) {
                $query->where($field, '!=', $value);
            }
        }

        if ($this->search) {
            $query->where(function (Builder $q) {
                foreach ($this->columns as $column) {
                    $field = is_array($column) ? ($column['field'] ?? null) : $column;
                    if ($field && !str_contains($field, '.') && !$this->isAccessor($field)) {
                        $q->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        $model = new $this->model;
        $query = $model->newQuery();
        $table = $model->getTable();

        if (method_exists($this->model, 'scopeCustomer')) {
            $query->customer();
        }


        if (!empty($this->constantFilter)) {
            foreach ($this->constantFilter as $field => $value) {
                $query->where($field, $value);
            }
        }


        if (!empty($this->constantFilterNot)) {
            foreach ($this->constantFilterNot as $field => $value) {
                $query->where($field, '!=', $value);
            }
        }

        if ($this->search) {
            $query->where(function (Builder $q) use ($table) {
                foreach ($this->columns as $column) {
                    $field = is_array($column) ? ($column['field'] ?? null) : $column;

                    if ($field && !str_contains($field, '.') && !$this->isAccessor($field)) {
                        $q->orWhere("$table.$field", 'like', '%' . $this->search . '%');
                    }
                }

                if (!empty($this->searchableRelations)) {
                    foreach ($this->searchableRelations as $relation => $config) {
                        $q->orWhereHas($relation, function ($query) use ($config) {
                            $query->where($config['column'], 'like', '%' . $this->search . '%');
                        });
                    }
                }
            });
        }

        if (!empty($this->filter)) {
            foreach ($this->filter as $field => $value) {
                if ($value) {
                    if (isset($this->searchableRelations[$field])) {
                        $relation = $this->searchableRelations[$field];
                        $query->whereHas($relation['relation'], function ($q) use ($relation, $value) {
                            $q->where($relation['column'], $value);
                        });
                    } else {
                        $query->where($field, $value);
                    }
                }
            }
        }

        if (isset($this->sortableRelations[$this->sortField])) {
            $relation = $this->sortableRelations[$this->sortField];

            if (isset($relation['table'])) {
                $query->join($relation['table'], $relation['first'], '=', $relation['second'])
                    ->select("$table.*")
                    ->orderBy($relation['column'], $this->sortDirection);
            } else if (isset($relation['relation']) && isset($relation['column'])) {
                $relationKey = $relation['relation_key'] ?? 'id';
                $foreignKey = $relation['foreign_key'] ?? $relation['relation'] . '_id';

                $subQuery = $model->{$relation['relation']}()->getRelated()
                    ->select($relationKey)
                    ->orderBy($relation['column'], $this->sortDirection);

                $query->whereIn($foreignKey, $subQuery->pluck($relationKey));
            }
        } else {
            if ($this->isAccessor($this->sortField)) {
                $items = $query->get();
                $sortDirection = $this->sortDirection;
                $sortField = $this->sortField;

                $sorted = $items->sort(function ($a, $b) use ($sortField, $sortDirection) {
                    if ($sortDirection === 'asc') {
                        return $a->$sortField <=> $b->$sortField;
                    } else {
                        return $b->$sortField <=> $a->$sortField;
                    }
                });

                $page = request()->get('page', 1);
                $items = new \Illuminate\Pagination\LengthAwarePaginator(
                    $sorted->forPage($page, $this->perPage),
                    $sorted->count(),
                    $this->perPage,
                    $page,
                    ['path' => request()->url()]
                );
            } else {
                $query->orderBy("$table.{$this->sortField}", $this->sortDirection);
                $items = $query->paginate($this->perPage);
            }
        }

        if (!isset($items)) {
            $items = $query->paginate($this->perPage);
        }

        return view('livewire.base-table', compact('items'));
    }

    protected function isAccessor($field)
    {
        $model = new $this->model;
        $method = 'get' . str_replace('_', '', ucwords($field, '_')) . 'Attribute';
        return method_exists($model, $method);
    }
}
