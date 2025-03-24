<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layout.nav')

    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-cPrimary/10 flex items-center justify-center text-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Additional Payment</h1>
                            <p class="text-gray-500">Order No. <span class="font-medium text-gray-700">{{ $order->order_id }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Customer</p>
                            <p class="font-medium">{{ $order->user->name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Order Date</p>
                            <p class="font-medium">{{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Apparel Type</p>
                            <p class="font-medium">{{ $order->apparelType->name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Production Method</p>
                            <p class="font-medium">{{ $order->productionType->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
                <!-- Left Column: Order Summary Card -->
                <div class="lg:col-span-3 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-gilroy font-bold text-xl mb-5">Order Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Original Quantity:</span>
                            <span class="font-medium">{{ $originalQuantity }} items</span>
                        </div>
                        <div class="flex justify-between items-center text-green-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <polyline points="19 12 12 19 5 12"></polyline>
                                </svg>
                                Additional Quantity:
                            </span>
                            <span class="font-medium">+ {{ $additionalQuantity }} items</span>
                        </div>
                        <div class="flex justify-between items-center font-medium border-t border-gray-200 pt-2">
                            <span>New Total Quantity:</span>
                            <span>{{ $newQuantity }} items</span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Unit Price:</span>
                            <span class="font-medium">₱{{ number_format($unitPrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Original Price:</span>
                            <span class="font-medium">₱{{ number_format($originalPrice, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Original Downpayment (Paid):</span>
                            <span class="font-medium">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-green-600">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <polyline points="19 12 12 19 5 12"></polyline>
                                </svg>
                                Additional Payment (Required):
                            </span>
                            <span class="font-medium">₱{{ number_format($amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Balance Due (Upon Completion):</span>
                            <span class="font-medium">₱{{ number_format($balanceDue, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center font-medium text-lg border-t border-gray-200 pt-3 mt-1">
                            <span>New Total Price:</span>
                            <span class="text-cPrimary">₱{{ number_format($newTotalPrice, 2) }}</span>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Please complete the payment for your additional quantity. After confirmation, you will be redirected to complete your order.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Details Card -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-gilroy font-bold text-xl mb-4">Payment Details</h2>

                    <div class="flex justify-center mb-6">
                        <div class="w-40 h-40 bg-gray-100 border border-gray-200 flex items-center justify-center rounded-lg">
                            @include('svgs.qr')
                        </div>
                    </div>

                    <div class="p-4 mb-4 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500 mr-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span class="font-medium text-blue-700">Payment Amount</span>
                        </div>
                        <p class="font-bold text-2xl text-cPrimary">₱{{ number_format($amount, 2) }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Company Name</p>
                            <p class="font-medium">{{ $productionCompany->company_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Account Name</p>
                            <p class="font-medium">{{ $productionCompany->company_name }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Account Number</p>
                            <div class="flex items-center justify-between">
                                <p class="font-medium tracking-wider">{{ $accountNumber }}</p>
                                <button onclick="copyToClipboard('{{ $accountNumber }}')" class="ml-2 p-1 text-cPrimary hover:bg-cPrimary/10 rounded transition-colors">
                                    <span class="sr-only">Copy to clipboard</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Payment Proof Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="font-gilroy font-bold text-xl mb-4">Upload Payment Proof</h2>

                <form action="{{ route('order.process-additional-payment', ['order_id' => $order->order_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="additional_quantity" value="{{ $additionalQuantity }}">
                    <input type="hidden" name="new_total_quantity" value="{{ $newQuantity }}">

                    <!-- Hidden input to store size data from the previous page -->
                    <input type="hidden" id="size_data" name="size_data" value="{{ request()->query('size_data', '') }}">

                    <div class="mb-6">
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">Upload Proof of Payment</label>
                        <div id="drop-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4h-12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-cPrimary hover:text-cPrimary/80 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-cPrimary">
                                        <span>Upload a file</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>

                        <div id="preview-container" class="mt-3 hidden">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">Payment Proof Preview:</p>
                                <button type="button" id="remove-image" class="text-sm text-red-600 hover:text-red-800">
                                    Remove
                                </button>
                            </div>
                            <div class="relative">
                                <img id="preview-image" src="#" alt="Payment proof preview" class="max-h-60 rounded border border-gray-200">
                                <p id="image-name" class="mt-1 text-xs text-gray-500"></p>
                            </div>
                        </div>

                        @error('payment_proof')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Your order will be confirmed after payment</h3>
                                <p class="mt-1 text-sm text-yellow-700">
                                    When you submit your payment proof, your order will be confirmed automatically. No need to return to the order form.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ back()->getTargetUrl() }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back
                        </a>
                        <button type="submit" id="confirm-button" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            Confirm Order & Submit Payment
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy to clipboard function
            window.copyToClipboard = function(text) {
                navigator.clipboard.writeText(text).then(function() {
                    // Show a customized toast notification instead of an alert
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded shadow-lg transform transition-transform duration-300 ease-in-out';
                    toast.textContent = 'Account number copied to clipboard!';
                    document.body.appendChild(toast);

                    // Animate the toast
                    setTimeout(() => {
                        toast.classList.add('translate-y-2');
                        setTimeout(() => {
                            toast.classList.remove('translate-y-2');
                            setTimeout(() => {
                                document.body.removeChild(toast);
                            }, 300);
                        }, 2000);
                    }, 100);

                }, function(err) {
                    console.error('Could not copy text: ', err);
                });
            };

            // Image preview functionality
            const input = document.getElementById('payment_proof');
            const dropArea = document.getElementById('drop-area');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const imageName = document.getElementById('image-name');
            const removeButton = document.getElementById('remove-image');

            // Only set up these listeners if elements exist
            if (input && dropArea && previewContainer && previewImage) {
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                // Highlight drop area when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });

                // Handle dropped files
                dropArea.addEventListener('drop', handleDrop, false);

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                function highlight() {
                    dropArea.classList.add('border-cPrimary', 'bg-cPrimary/5');
                }

                function unhighlight() {
                    dropArea.classList.remove('border-cPrimary', 'bg-cPrimary/5');
                }

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    handleFiles(files);
                }

                function handleFiles(files) {
                    if (files.length) {
                        uploadFile(files[0]);
                    }
                }

                function uploadFile(file) {
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('Please upload an image file');
                        return;
                    }

                    // Only handle images
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function() {
                        showPreview(reader.result, file.name);

                        // Clear and set the file in the input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                    };
                }

                function showPreview(src, fileName) {
                    previewImage.src = src;
                    if (imageName) {
                        imageName.textContent = fileName;
                    }
                    dropArea.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }

                // Handle file selection via input
                input.addEventListener('change', function() {
                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            showPreview(e.target.result, file.name);
                        };

                        reader.readAsDataURL(file);
                    }
                });

                // Remove image button functionality
                if (removeButton) {
                    removeButton.addEventListener('click', function() {
                        input.value = '';
                        previewContainer.classList.add('hidden');
                        dropArea.classList.remove('hidden');

                        // Clear preview
                        setTimeout(() => {
                            previewImage.src = '';
                            if (imageName) {
                                imageName.textContent = '';
                            }
                        }, 300);
                    });
                }
            }

            // Handle the confirmation button
            const confirmButton = document.getElementById('confirm-button');
            const form = confirmButton ? confirmButton.closest('form') : null;

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (input && input.files.length === 0) {
                        e.preventDefault();
                        alert('Please upload a proof of payment');
                        return false;
                    }

                    // Add loading state to button
                    if (confirmButton) {
                        confirmButton.disabled = true;
                        confirmButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                    }
                });
            }
        });
    </script>
</body>