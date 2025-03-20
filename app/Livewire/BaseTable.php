<?php

namespace App\Livewire;

use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Livewire\Component;
use Livewire\WithPagination;

class BaseTable extends Component
{
    public $model; // The model class name
    public $columns = [];
    public $actions = [];
    public $search = '';
    public $filter = [];
    public $sortField;
    public $sortDirection = 'asc';
    public $primaryKey;

    /**
     * Mount the component.
     *
     * @param  string  $model      The model class name (e.g. App\Models\User)
     * @param  array   $columns    Array of columns.
     * @param  array   $actions    Array of actions.
     * @param  string  $primaryKey The primary key field (default "id").
     */
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Rebuild the query from the model
        $query = (new $this->model)->newQuery();

        // If your model has a local scope named "customer", you can apply it:
        if (method_exists($this->model, 'customer')) {
            $query = $query->customer();
        }

        // Apply search filtering across the columns.
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

        // Apply additional filters if provided.
        if (!empty($this->filter)) {
            foreach ($this->filter as $field => $value) {
                if ($value) {
                    $query->where($field, $value);
                }
            }
        }

        // Order and paginate: this returns a paginator instance.
        $items = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.base-table', compact('items'));
    }
}
