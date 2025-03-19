<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layout.nav')

    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-cPrimary">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span>Payment</span>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-cPrimary/10 flex items-center justify-center text-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Payment Methods</h1>
                            <p class="text-gray-500">Order No. <span class="font-medium text-gray-700" id="order-id">{{ $order->order_id ?? '123456' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <!-- Left Column: Production Company Info and QR Code -->
                <div class="col-span-3 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-gilroy font-bold text-xl text-gray-900 mb-4">Production Company Payment Details</h2>

                    <div class="mb-6">
                        <h3 class="font-medium text-gray-900 mb-2">{{ $productionCompany->company_name ?? 'TelaPrints Manufacturing' }}</h3>
                        <p class="text-gray-600 mb-4">Please scan the QR code below or use the provided account details to make your payment.</p>

                        <div class="flex flex-col items-center justify-center p-6 bg-gray-50 rounded-lg mb-4">
                            <!-- Sample QR Code (this is a placeholder SVG) -->
                            <div class="mb-4 w-48 h-48 flex items-center justify-center bg-white p-3 rounded-lg shadow-sm">
                                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                    <!-- Background -->
                                    <rect x="0" y="0" width="100" height="100" fill="white" />

                                    <!-- QR Code Pattern (simplified) -->
                                    <rect x="10" y="10" width="20" height="20" fill="black" />
                                    <rect x="70" y="10" width="20" height="20" fill="black" />
                                    <rect x="10" y="70" width="20" height="20" fill="black" />

                                    <rect x="35" y="10" width="5" height="5" fill="black" />
                                    <rect x="45" y="10" width="5" height="5" fill="black" />
                                    <rect x="60" y="10" width="5" height="5" fill="black" />

                                    <rect x="10" y="35" width="5" height="5" fill="black" />
                                    <rect x="20" y="35" width="5" height="5" fill="black" />
                                    <rect x="35" y="35" width="5" height="5" fill="black" />
                                    <rect x="60" y="35" width="5" height="5" fill="black" />
                                    <rect x="70" y="35" width="5" height="5" fill="black" />
                                    <rect x="85" y="35" width="5" height="5" fill="black" />

                                    <rect x="10" y="45" width="5" height="5" fill="black" />
                                    <rect x="35" y="45" width="5" height="5" fill="black" />
                                    <rect x="45" y="45" width="5" height="5" fill="black" />
                                    <rect x="60" y="45" width="5" height="5" fill="black" />
                                    <rect x="70" y="45" width="5" height="5" fill="black" />

                                    <rect x="10" y="60" width="5" height="5" fill="black" />
                                    <rect x="20" y="60" width="5" height="5" fill="black" />
                                    <rect x="35" y="60" width="5" height="5" fill="black" />
                                    <rect x="45" y="60" width="5" height="5" fill="black" />
                                    <rect x="60" y="60" width="5" height="5" fill="black" />

                                    <rect x="35" y="70" width="5" height="5" fill="black" />
                                    <rect x="45" y="70" width="5" height="5" fill="black" />
                                    <rect x="55" y="70" width="5" height="5" fill="black" />
                                    <rect x="65" y="70" width="5" height="5" fill="black" />
                                    <rect x="75" y="70" width="5" height="5" fill="black" />
                                    <rect x="85" y="70" width="5" height="5" fill="black" />

                                    <rect x="35" y="85" width="5" height="5" fill="black" />
                                    <rect x="45" y="85" width="5" height="5" fill="black" />
                                    <rect x="55" y="85" width="5" height="5" fill="black" />
                                    <rect x="75" y="85" width="5" height="5" fill="black" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">Scan to pay</p>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-medium text-gray-900 mb-2">Bank Transfer Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bank Name:</span>
                                    <span class="font-medium">BDO</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Account Name:</span>
                                    <span class="font-medium">TelaPrints Manufacturing</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Account Number:</span>
                                    <span class="font-medium">1234 5678 9012 3456</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary and Payment Upload -->
                <div class="col-span-2 space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="font-gilroy font-bold text-xl text-gray-900 mb-4">Order Summary</h2>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium" id="summary-quantity">{{ $quantity ?? '5' }} items</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Unit Price:</span>
                                <span class="font-medium">₱{{ number_format(floatval($unitPrice ?? 500), 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Original Downpayment (Paid):</span>
                                <span class="font-medium">₱{{ number_format(floatval($originalDownpayment ?? 1250), 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 pt-2 mt-2">
                                <span class="text-gray-800 font-medium">Additional Payment:</span>
                                <span class="text-orange-600 font-bold text-lg">₱{{ number_format(floatval($additionalPayment ?? 500), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof Upload -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="font-gilroy font-bold text-xl text-gray-900 mb-4">Upload Payment Proof</h2>

                        <form id="payment-form" action="{{ route('customer.payment.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id ?? '123456' }}">
                            <input type="hidden" name="amount" value="{{ floatval($additionalPayment ?? 500) }}">

                            <div class="mb-6">
                                <label for="payment_proof" class="block font-medium text-gray-700 mb-2">Payment Screenshot</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" id="drop-area">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex justify-center text-sm text-gray-600">
                                            <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-cPrimary hover:text-cPrimary/80 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required>
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                </div>
                                <div id="preview-container" class="mt-4 hidden">
                                    <div class="relative">
                                        <img id="preview-image" src="#" alt="Payment proof" class="max-h-48 rounded-md mx-auto">
                                        <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" id="confirm-button" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                    Confirm Payment & Finalize Order
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('payment_proof');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const removeButton = document.getElementById('remove-image');
            const confirmButton = document.getElementById('confirm-button');
            const paymentForm = document.getElementById('payment-form');

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-cPrimary', 'bg-cPrimary/5');
            }

            function unhighlight() {
                dropArea.classList.remove('border-cPrimary', 'bg-cPrimary/5');
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length) {
                    fileInput.files = files;
                    updateImagePreview(files[0]);
                }
            }

            // Handle file selection via file input
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length) {
                    updateImagePreview(fileInput.files[0]);
                }
            });

            // Update image preview
            function updateImagePreview(file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        confirmButton.disabled = false;
                    };

                    reader.readAsDataURL(file);
                }
            }

            // Remove image
            removeButton.addEventListener('click', function() {
                fileInput.value = "";
                previewContainer.classList.add('hidden');
                confirmButton.disabled = true;
            });

            // Form submission
            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get the form data
                    const formData = new FormData(this);

                    // Show loading state
                    const submitButton = document.getElementById('confirm-button');
                    const originalButtonText = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Send the form data to the server using fetch
                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                alert(data.message || 'Payment proof submitted successfully! Your order has been updated.');

                                // Redirect to the specified URL
                                window.location.href = data.redirect || "{{ route('home') }}";
                            } else {
                                throw new Error(data.message || 'An error occurred');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while processing your payment: ' + error.message);

                            // Reset button state
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalButtonText;
                        });
                });
            }
        });
    </script>
</body>

</html>