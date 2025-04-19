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

    public function mount($reporterClass, $reporterId, $reportedClass, $reportedId, $orderId)
    {
        $this->reporterClass = $reporterClass;
        $this->reporterId = $reporterId;
        $this->reportedClass = $reportedClass;
        $this->reportedId = $reportedId;
        $this->orderId = $orderId;
    }

    public function triggerReport()
    {
        $this->dispatch('reportEntity', [
            'reporterClass' => $this->reporterClass,
            'reporterId' => $this->reporterId,
            'reportedClass' => $this->reportedClass,
            'reportedId' => $this->reportedId,
            'orderId' => $this->orderId,
        ]);
    }

    public function render()
    {
        return view('livewire.report-button');
    }
}
