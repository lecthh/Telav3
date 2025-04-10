<?php

namespace App\Livewire;

use Livewire\Component;

class ReportButton extends Component
{
    public $reporterClass;
    public $reporterId;
    public $reportedClass;
    public $reportedId;

    public function mount($reporterClass, $reporterId, $reportedClass, $reportedId)
    {
        $this->reporterClass = $reporterClass;
        $this->reporterId = $reporterId;
        $this->reportedClass = $reportedClass;
        $this->reportedId = $reportedId;
    }

    public function triggerReport()
    {
        $this->dispatch('reportEntity', [
            'reporterClass' => $this->reporterClass,
            'reporterId' => $this->reporterId,
            'reportedClass' => $this->reportedClass,
            'reportedId' => $this->reportedId
        ]);
    }

    public function render()
    {
        return view('livewire.report-button');
    }
}
