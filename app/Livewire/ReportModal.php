<?php

namespace App\Livewire;

use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;

class ReportModal extends Component
{
    use WithFileUploads;

    public $reporterClass;
    public $reporterId;
    public $reportedClass;
    public $reportedId;
    public $selectedCommonReasons = [];
    public $reason;
    public $showModal = false;
    public $images = [];

    protected function getListeners()
    {
        Log::info('getListeners called');
        return ['reportEntity' => 'showReportModal'];
    }

    public function showReportModal($data)
    {
        $this->reporterClass = $data['reporterClass'];
        $this->reporterId = $data['reporterId'];
        $this->reportedClass = $data['reportedClass'];
        $this->reportedId = $data['reportedId'];
        $this->showModal = true;
    }

    /**
     * Helper to compose the final reason from the custom input and selected common reasons.
     */
    protected function composeFinalReason()
    {
        $customReason = trim($this->reason);
        $html = '';

        if (!empty($this->selectedCommonReasons)) {
            $html .= '<ul>';
            foreach ($this->selectedCommonReasons as $common) {
                $html .= '<li>' . e($common) . '</li>';
            }
            $html .= '</ul>';
        }

        if (!empty($customReason)) {
            $html .= '<p>' . e($customReason) . '</p>';
        }

        return $html;
    }

    /**
     * Remove an image from the temporary uploaded images array
     */
    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    /**
     * Report action: create a report record and show a success toast.
     */
    public function reportConfirmed()
    {
        try {
            // Check to be sure we have valid reporter and reported identifiers.
            if (empty($this->reporterId) || empty($this->reportedId)) {
                Log::error('Invalid reporter or reported IDs');
                return;
            }

            $finalReason = $this->composeFinalReason();

            // Create the report record
            $report = Report::create([
                'reporter_type' => $this->reporterClass,
                'reporter_id'   => $this->reporterId,
                'reported_type' => $this->reportedClass,
                'reported_id'   => $this->reportedId,
                'reason'        => $finalReason,
                'status'        => 'pending'
            ]);

            // Handle image uploads
            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    // Store the image in a reports folder with a unique name
                    $path = $image->store('reports', 'public');

                    // Create image record in the database
                    ReportImage::create([
                        'report_id' => $report->id,
                        'path' => $path,
                        'filename' => $image->getClientOriginalName(),
                        'mime_type' => $image->getMimeType(),
                        'size' => $image->getSize()
                    ]);
                }
            }

            // Dispatch a toast (you can listen to this event in your frontend JS)
            $this->dispatch('toast', [
                'message' => 'Report submitted successfully.',
                'type' => 'success'
            ]);

            $this->resetModal();
        } catch (\Exception $e) {
            Log::error("Error creating report: " . $e->getMessage());
            $this->dispatch('action-error', [
                'message' => 'Failed to submit report: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Resets the modal and fields.
     */
    public function resetModal()
    {
        $this->selectedCommonReasons = [];
        $this->reason = '';
        $this->reporterClass = null;
        $this->reporterId = null;
        $this->reportedClass = null;
        $this->reportedId = null;
        $this->images = [];
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.report-modal');
    }
}
