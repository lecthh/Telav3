<?php

namespace App\Livewire;

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


    public function mount($model, $columns = [], $actions = [], $primaryKey = 'id')
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->actions = $actions;
        $this->primaryKey = $primaryKey;
        $this->sortField = $primaryKey;
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


    public function render()
    {
        sleep(1);
        // Rebuild the query from the model
        $query = (new $this->model)->newQuery();

        if (method_exists($this->model, 'customer')) {
            $query = $query->customer();
        }

        if ($this->search) {
            $query->where(function ($q) {
                foreach ($this->columns as $column) {
                    $field = is_array($column) ? ($column['field'] ?? null) : $column;
                    if ($field) {
                        $q->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        if (!empty($this->constantFilter)) {
            foreach ($this->constantFilter as $field => $value) {
                $query->where($field, $value);
            }
        }


        if (!empty($this->filter)) {
            foreach ($this->filter as $field => $value) {
                if ($value) {
                    $query->where($field, $value);
                }
            }
        }

        $items = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.base-table', compact('items'));
    }
}
