<?php

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ReportDetailsModal extends Component
{
    public $showModal = false;
    public $selectedReport = null;
    public $activeTab = 'profile';
    public $showImageModal = false;
    public $selectedImageId = null;

    protected function getListeners()
    {
        return [
            'openReportDetailsModal' => 'showDetails',
        ];
    }

    public function showDetails($reportId)
    {
        $report = Report::with(['reporter', 'reported', 'order', 'order.status'])
            ->findOrFail($reportId);

        logger()->info('Loaded report:', ['report' => $report]);

        $this->selectedReport = $report;
        $this->activeTab = 'details';
        $this->showModal = true;
    }


    public function updateStatus($reportId, $status)
    {
        $report = Report::findOrFail($reportId);
        $report->status = $status;
        $report->save();

        $this->selectedReport = $report->fresh(['reporter', 'reported', 'order', 'order.status']);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => "Report status updated to {$status}."
        ]);
        $this->dispatch('$refresh');
    }

    public function viewImage($imageId)
    {
        $this->selectedImageId = $imageId;
        $this->showImageModal = true;
    }

    public function viewOrder($orderId)
    {
        $this->dispatch('showOrderDetails', $orderId);
    }

    public function viewEntity($type, $entityId, $entityType)
    {
        if (strpos($entityType, 'User') !== false) {
            $this->dispatch('showUserDetails', $entityId);
        } elseif (strpos($entityType, 'ProductionCompany') !== false) {
            $this->dispatch('showCompanyDetails', $entityId, 'manage');
        }
    }

    public function render()
    {
        return view('livewire.report-details-modal');
    }
}
