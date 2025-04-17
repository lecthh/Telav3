<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;

class ReportTable extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
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

    public function showReport($reportId)
    {
        $this->dispatch('openReportDetailsModal', reportId: $reportId);
    }

    public function render()
    {
        $reports = Report::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('id', 'like', "%{$this->search}%")
                        ->orWhere('reason', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                    // Note: Searching through polymorphic relationships is more complex
                    // and might need custom implementation based on your needs
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.report-table', [
            'reports' => $reports
        ]);
    }
}
