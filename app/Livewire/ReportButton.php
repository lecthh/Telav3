<?php

namespace App\Livewire;

use Livewire\Component;

class ReportButton extends Component
{
    public $reporterClass;
    public $reporterId;
    public $reportedClass;
    public $reportedId;
    public $orderId;
    public $entityName;

    public function mount($reporterClass, $reporterId, $reportedClass, $reportedId, $orderId, $entityName)
    {
        $this->reporterClass = $reporterClass;
        $this->reporterId = $reporterId;
        $this->reportedClass = $reportedClass;
        $this->reportedId = $reportedId;
        $this->orderId = $orderId;
        $this->entityName = $entityName;
    }

    public function triggerReport()
    {
        $this->dispatch('reportEntity', [
            'reporterClass' => $this->reporterClass,
            'reporterId' => $this->reporterId,
            'reportedClass' => $this->reportedClass,
            'reportedId' => $this->reportedId,
            'orderId' => $this->orderId,
            'entityName' => $this->entityName,
        ]);
    }

    public function render()
    {
        return view('livewire.report-button');
    }
}
