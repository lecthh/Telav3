<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen bg-gray-50">
    <div class="flex flex-col flex-grow">
        <!-- Header Bar -->
        <div class="flex p-2 bg-cGreen font-gilroy font-bold text-black text-sm justify-center items-center shadow-sm">
            Designer Hub
        </div>
        
        <div class="flex flex-grow">
            <!-- Sidebar -->
            @include('layout.designer')
            
            <!-- Main Content -->
            <div class="flex flex-col gap-y-6 p-6 md:p-10 bg-gray-50 w-full overflow-auto">
                <!-- Header with Breadcrumbs -->
                <div class="flex flex-col gap-y-3">
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <a href="{{ route('partner.designer.orders') }}" class="hover:text-cGreen transition-colors">Orders</a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="font-medium">Order #{{ substr($order->order_id, -6) }}</span>
                    </div>
                    
                    <h1 class="font-gilroy font-bold text-2xl text-gray-900">Order Details</h1>
                    
                    <!-- Status Badge -->
                    <div class="inline-flex items-center mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            {{ $order->status->name }}
                        </span>
                        <span class="ml-2 text-sm text-gray-600">Created on {{ $order->created_at->format('F j, Y') }}</span>
                    </div>
                </div>
                
                <!-- Order Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Left Column - Order Info -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="font-gilroy font-bold text-lg text-gray-900">Order Information</h2>
                            </div>
                            
                            <!-- Order Info List -->
                            <div class="divide-y divide-gray-100">
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.calendar')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Date Requested</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.user-single')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Customer</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.shirt')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Apparel Type</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $order->apparelType->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.receipt-check')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Order Specifications</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $order->is_bulk_order ? 'Bulk' : 'Single' }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-1">
                                                {{ $order->is_customized ? 'Personalized' : 'Standard' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="px-6 py-4 flex items-start">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                                        @include('svgs.paintbrush')
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Design Status</h3>
                                        <p class="mt-1 text-sm text-gray-600">Ready for design upload</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Order Specifications and Actions -->
                    <div class="md:col-span-2">
                        <!-- Order Specifications -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <h2 class="font-gilroy font-bold text-lg text-gray-900">Order Specifications</h2>
                            </div>
                            
                            <div class="p-6">
                                <!-- Customer Images -->
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-3">Customer Supplied Images</h3>
                                    @if($order->imagesWithStatusOne->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($order->imagesWithStatusOne as $image)
                                        <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 hover:border-cGreen transition-colors">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Order Image" class="w-full h-full object-cover">
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-gray-500 text-sm">No images provided by customer.</p>
                                    @endif
                                </div>
                                
                                <!-- Description -->
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-3">Customer Instructions</h3>
                                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        @if($order->custom_design_info)
                                        <p class="text-gray-700 whitespace-pre-line">{{ $order->custom_design_info }}</p>
                                        @else
                                        <p class="text-gray-500 text-sm">No specific instructions provided.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Design Upload -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="font-gilroy font-bold text-lg text-gray-900">Design Submission</h2>
                            </div>
                            
                            <form id="design-upload-form" action="{{ route('partner.designer.assigned-x-post', ['order_id' => $order->order_id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="p-6">
                                    <!-- Preview Container -->
                                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                        <!-- Image previews will be added here dynamically -->
                                    </div>
                                    
                                    <!-- File Upload Area -->
                                    <div class="flex flex-col items-center p-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-700">
                                            <span class="font-medium">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF up to 10MB
                                        </p>
                                        <label for="file-input" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cGreen hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen cursor-pointer">
                                            Browse Files
                                            <input id="file-input" class="hidden" type="file" name="vacancyImageFiles[]" multiple>
                                        </label>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row justify-between pt-6 border-t border-gray-100">
                                        <div class="flex flex-col sm:flex-row gap-3 mb-4 sm:mb-0">
                                            @if($order->status_id <= 3)
                                            <form action="{{ route('partner.designer.cancel-design-assignment', ['order_id' => $order->order_id]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Cancel Assignment
                                                </button>
                                            </form>
                                            @endif
                                            
                                            <button type="button" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                Message Client
                                            </button>
                                        </div>
                                        
                                        <button id="confirm-design" type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cGreen hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Submit Design
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layout.footer')
    
    <script>
        // File upload handling
        document.getElementById('file-input').addEventListener('change', function(event) {
            const input = event.target;
            const previewContainer = document.getElementById('preview-container');
            const confirmButton = document.getElementById('confirm-design');
            
            previewContainer.innerHTML = '';
            
            if (input.files.length > 0) {
                // Show submission button
                confirmButton.classList.remove('hidden');
                
                // Create previews
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewCard = document.createElement('div');
                        previewCard.className = 'relative aspect-square rounded-lg overflow-hidden border border-gray-200 group';
                        
                        const previewImage = document.createElement('img');
                        previewImage.src = e.target.result;
                        previewImage.className = 'w-full h-full object-cover';
                        
                        const overlay = document.createElement('div');
                        overlay.className = 'absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity';
                        
                        const filename = document.createElement('p');
                        filename.className = 'text-white text-xs truncate max-w-full px-2';
                        filename.textContent = file.name;
                        
                        overlay.appendChild(filename);
                        previewCard.appendChild(previewImage);
                        previewCard.appendChild(overlay);
                        previewContainer.appendChild(previewCard);
                    };
                    
                    reader.readAsDataURL(file);
                });
            } else {
                confirmButton.classList.add('hidden');
            }
        });
        
        // Optional: Drag and drop functionality
        const dropArea = document.getElementById('preview-container').parentElement;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-cGreen', 'bg-green-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-cGreen', 'bg-green-50');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const fileInput = document.getElementById('file-input');
            
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    </script>
</body>

</html>