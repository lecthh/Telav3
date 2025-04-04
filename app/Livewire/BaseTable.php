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
    public $selectedItems = [];
    public $selectedItem;
    public $showDetailsModal = false;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $onRowClick;
    public $onApprove;
    public $nameColumn;
    public $selectAll = false;
    public $bulkAction;
    public $type;

    protected $listeners = [
        'refreshTable' => 'handleRefreshTable'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function mount($model, $columns = [], $primaryKey = 'id', $sortableRelations = [], $searchableRelations = [], $perPage = 10, $onRowClick, $type)
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->primaryKey = $primaryKey;
        $this->sortField = $primaryKey;
        $this->sortableRelations = $sortableRelations;
        $this->searchableRelations = $searchableRelations;
        $this->perPage = $perPage;
        $this->onRowClick = $onRowClick;
        $this->type = $type;
    }

    public function handleRefreshTable()
    {
        $this->clearSelectedItems();
        $this->dispatch('$refresh');
    }

    public function getHasSelectedItemsProperty()
    {
        return count($this->selectedItems) > 0;
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

    public function openDetails($id)
    {
        $this->dispatch($this->onRowClick, $id);
    }

    public function openApproveModal($id)
    {
        Log::info($this->selectedItem);
        $this->dispatch($this->onApprove, $this->model, [$id], $this->type, $this->nameColumn, $this->primaryKey);
    }

    public function clearSelectedItems()
    {
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function openDeleteModal($id)
    {
        $this->dispatch('deleteEntity', $this->model, $id, $this->type, $this->nameColumn, $this->primaryKey);
    }

    public function bulkDelete()
    {
        $this->dispatch('deleteEntity', $this->model, $this->selectedItems, $this->nameColumn, $this->primaryKey);
    }

    public function bulkApprove()
    {
        $this->dispatch('approveEntity', $this->model, $this->selectedItems, $this->nameColumn, $this->primaryKey);
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

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // Get the current page items and extract their IDs
            $currentPageItems = $this->getCurrentPageItems();
            $this->selectedItems = $currentPageItems->pluck($this->primaryKey)->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    // Method to toggle selection of a specific item
    public function toggleSelection($id)
    {
        // Convert ID to string to ensure comparison works with UUIDs
        $id = (string) $id;

        if (in_array($id, $this->selectedItems)) {
            // Remove the item
            $this->selectedItems = array_values(array_diff($this->selectedItems, [$id]));
            $this->selectAll = false;
        } else {
            // Add the item
            $this->selectedItems[] = $id;

            // Check if all items on the current page are now selected
            $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
            $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
        }
    }

    public function getSelectedItemsOnCurrentPageCount()
    {
        $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
        return count(array_intersect($this->selectedItems, $currentPageIds));
    }

    public function getSelectedItemsNotOnCurrentPageCount()
    {
        $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
        return count(array_diff($this->selectedItems, $currentPageIds));
    }

    // Reset selection after item deletion
    public function resetSelection()
    {
        // Get all valid IDs from the query
        $allValidIds = $this->buildQuery()->pluck($this->primaryKey)->toArray();

        // Keep only valid IDs in the selectedItems array
        $this->selectedItems = array_values(array_intersect($this->selectedItems, $allValidIds));

        // Update selectAll status for current page
        $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
        if (count($currentPageIds) > 0) {
            $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
        } else {
            $this->selectAll = false;
        }
    }

    // Method to build the query (extracted from your render method)
    protected function buildQuery()
    {
        $model = new $this->model;
        $query = $model->newQuery();
        $table = $model->getTable();

        if (method_exists($this->model, 'scopeCustomer')) {
            $query->customer();
        }

        // Apply constant filters
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

        // Apply search
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

        // Apply filters
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

        // Apply sorting
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
            if (!$this->isAccessor($this->sortField)) {
                $query->orderBy("$table.{$this->sortField}", $this->sortDirection);
            }
        }

        return $query;
    }

    // Helper method to get current page items
    protected function getCurrentPageItems()
    {
        $query = $this->buildQuery();

        // Handle accessor fields (same as in your render method)
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

            // Get current page items
            return $sorted->forPage($this->page, $this->perPage);
        } else {
            // Get current page items from paginated result
            return $query->paginate($this->perPage)->getCollection();
        }
    }

    public function updatedPage($page)
    {
        $this->page = $page;

        // Update selectAll status for the new page
        $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
        if (count($currentPageIds) > 0) {
            $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
        } else {
            $this->selectAll = false;
        }
    }

    // When items per page changes
    public function updatedPerPage()
    {
        // Reset to first page when changing items per page
        $this->resetPage();

        // Update selectAll status
        $currentPageIds = $this->getCurrentPageItems()->pluck($this->primaryKey)->toArray();
        if (count($currentPageIds) > 0) {
            $this->selectAll = count(array_intersect($currentPageIds, $this->selectedItems)) === count($currentPageIds);
        } else {
            $this->selectAll = false;
        }
    }

    // Your existing render method would still be used, but we extract the query building
    // part to the buildQuery method above to avoid code duplication
    public function render()
    {
        $query = $this->buildQuery();

        // The rest of your render method stays the same
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
