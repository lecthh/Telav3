<div>
    @if($showModal)
    <x-view-details-modal title="Report Submission" wire:model="showModal">
        <div class="bg-white px-6 pt-6 pb-5 sm:p-7">
            <div class="sm:flex sm:items-start">
                <!-- Warning Icon -->
                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="mt-3 text-center sm:mt-0 sm:ml-5 sm:text-left w-full">
                    <h3 class="text-lg font-semibold text-gray-900" id="report-modal-title">
                        Report This Content
                    </h3>

                    <!-- Introduction text -->
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">
                            Please help us understand the issue by selecting applicable reasons and providing any additional details.
                        </p>
                    </div>

                    <!-- Report data (hidden fields) -->
                    <input type="hidden" wire:model="reporterClass">
                    <input type="hidden" wire:model="reporterId">
                    <input type="hidden" wire:model="reportedClass">
                    <input type="hidden" wire:model="reportedId">

                    <!-- Common reasons fieldset -->
                    <fieldset class="mt-5">
                        <legend class="text-sm font-medium text-gray-800">Select reason(s) for reporting:</legend>
                        <div class="mt-3 space-y-3">
                            <label class="relative flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input id="reason-fraudulent" type="checkbox" wire:model="selectedCommonReasons" value="Fraudulent behavior" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Fraudulent behavior</span>
                                    <p class="text-gray-500">False information, scams, or deceptive practices</p>
                                </div>
                            </label>

                            <label class="relative flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input id="reason-misconduct" type="checkbox" wire:model="selectedCommonReasons" value="Misconduct" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Misconduct</span>
                                    <p class="text-gray-500">Inappropriate behavior or actions</p>
                                </div>
                            </label>

                            <label class="relative flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input id="reason-policy" type="checkbox" wire:model="selectedCommonReasons" value="Policy violation" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Policy violation</span>
                                    <p class="text-gray-500">Content that breaks our community guidelines</p>
                                </div>
                            </label>

                            <label class="relative flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input id="reason-harmful" type="checkbox" wire:model="selectedCommonReasons" value="Harmful content" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Harmful content</span>
                                    <p class="text-gray-500">Content that may cause harm or offense</p>
                                </div>
                            </label>
                        </div>
                    </fieldset>

                    <!-- Additional details textarea -->
                    <div class="mt-5">
                        <label for="report-reason" class="block text-sm font-medium text-gray-700">Additional details:</label>
                        <div class="mt-2">
                            <textarea
                                id="report-reason"
                                wire:model="reason"
                                rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Please provide specific details about your report..."
                                aria-describedby="reason-description"></textarea>
                            <p class="mt-1 text-xs text-gray-500" id="reason-description">
                                Your detailed feedback helps us take appropriate action.
                            </p>
                        </div>
                    </div>

                    <!-- Image upload section -->
                    <!-- Image upload section with client-side preview using Alpine.js -->
                    <div class="mt-5" x-data="imagePreviewHandler()">
                        <label class="block text-sm font-medium text-gray-700">Supporting evidence (optional):</label>
                        <div class="mt-2">
                            <div
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="space-y-2">
                                <label for="report-images" class="flex justify-center w-full px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-50">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <span class="relative font-medium text-indigo-600 hover:text-indigo-500">
                                                Upload images
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF up to 5MB
                                        </p>
                                    </div>
                                    <input id="report-images" type="file" wire:model="images"
                                        class="sr-only" multiple accept="image/*"
                                        x-ref="fileInput"
                                        @change="updatePreviews($event)">
                                </label>

                                <!-- Upload progress bar -->
                                <div x-show="isUploading" class="w-full">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" x-bind:style="`width: ${progress}%`"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-center" x-text="`Uploading: ${progress}%`"></p>
                                </div>

                                <!-- Image preview section using client-side previews -->
                                <div x-show="previews.length" class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2" x-text="`Selected images: ${previews.length}`"></h4>
                                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                                        <template x-for="(src, index) in previews" :key="index">
                                            <div class="relative group">
                                                <div class="w-full h-24 overflow-hidden rounded-md bg-gray-200 flex items-center justify-center">
                                                    <img :src="src" alt="Image preview" class="object-cover w-full h-full">
                                                </div>
                                                <button type="button"
                                                    @click="removePreview(index)"
                                                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center transform -translate-y-1/2 translate-x-1/2 opacity-90 hover:opacity-100">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-7">
            <button
                type="button"
                wire:click="reportConfirmed"
                wire:loading.attr="disabled"
                wire:target="reportConfirmed, images"
                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 sm:w-auto sm:ml-3">
                <span wire:loading.remove wire:target="reportConfirmed">Submit Report</span>
                <span wire:loading wire:target="reportConfirmed" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting...
                </span>
            </button>
            <button
                type="button"
                wire:click="resetModal"
                wire:loading.attr="disabled"
                wire:target="resetModal, reportConfirmed, images"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 sm:mt-0 sm:w-auto">
                Cancel
            </button>
        </div>
    </x-view-details-modal>
    @endif


</div>

<script>
    function imagePreviewHandler() {
        return {
            previews: [],
            updatePreviews(event) {
                // Reset the previews array
                this.previews = [];
                // Use the File API to create object URLs for the selected files
                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    this.previews.push(URL.createObjectURL(files[i]));
                }
            },
        }
    }
</script>