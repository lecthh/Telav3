<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/customize.js')
</head>

<body class="min-h-screen bg-gray-50">
    @include('layout.nav')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <form method="POST" action="{{ route('customer.place-order.customization-post', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) }}" enctype="multipart/form-data" class="animate-fade-in">
            @csrf
            
            <!-- Header Section -->
            <div class="mb-8 md:mb-12">
                @include('customer.place-order.steps')
                <div class="mt-8 space-y-3">
                    <h1 class="font-gilroy font-bold text-3xl md:text-4xl lg:text-5xl text-gray-900">Customize Your Apparel</h1>
                    <p class="font-inter text-lg text-gray-600 max-w-3xl">Now it's time to get creative! Add your unique design, choose your colors, and make any other custom adjustments to create something truly one-of-a-kind.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas Editor -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Canvas Tool -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-gilroy font-bold text-lg text-gray-900">Design Canvas</h3>
                            <!-- <div class="flex gap-x-2">
                                <button type="button" id="canvasResetBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset
                                </button>
                                <button type="button" id="canvasUndoBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none text-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Undo
                                </button>
                            </div> -->
                        </div>
                        
                        <div class="p-6">
                            <div class="flex gap-x-4">
                                <div class="flex flex-col justify-between gap-y-4">
                                    <!-- Tool Buttons -->
                                    <div class="flex flex-col gap-y-3">
                                        <div id="canvasText" class="w-10 h-10 border border-gray-300 rounded-md cursor-pointer transition-all hover:bg-purple-50 hover:border-cPrimary flex justify-center items-center text-gray-700 hover:text-cPrimary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M4 7V4h16v3"></path>
                                                <path d="M9 20h6"></path>
                                                <path d="M12 4v16"></path>
                                            </svg>
                                        </div>
                                        <div id="canvasImg" class="w-10 h-10 border border-gray-300 rounded-md cursor-pointer transition-all hover:bg-purple-50 hover:border-cPrimary flex justify-center items-center text-gray-700 hover:text-cPrimary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                        </div>
                                        <div id="canvasDraw" class="w-10 h-10 border border-gray-300 rounded-md cursor-pointer transition-all hover:bg-purple-50 hover:border-cPrimary flex justify-center items-center text-gray-700 hover:text-cPrimary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                                <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                                                <path d="M2 2l7.586 7.586"></path>
                                                <circle cx="11" cy="11" r="2"></circle>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <div id="deleteObject" class="w-10 h-10 border border-gray-300 rounded-md cursor-pointer transition-all hover:bg-red-50 hover:border-red-500 flex justify-center items-center text-gray-700 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Canvas -->
                                <div class="relative flex-1 bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <canvas id="fabricCanvas" width="1000" height="500" class="w-full"></canvas>
                                    <input type="file" id="canvasImgUpload" class="hidden" accept="image/*" />
                                </div>
                            </div>
                            
                            <!-- Canvas Hint -->
                            <div class="mt-4 text-sm text-gray-500 bg-gray-50 p-3 rounded-md flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <p>Use the tools on the left to add text, upload images, or draw directly on the canvas. Selected elements can be moved, resized, or deleted.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description Field -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-gilroy font-bold text-lg text-gray-900">Design Description</h3>
                        </div>
                        
                        <div class="p-6">
                            <div x-data="{ charCount: 0, maxChars: 500 }">
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="4" 
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:border-cPrimary focus:ring focus:ring-cPrimary focus:ring-opacity-20 transition-all" 
                                    placeholder="Please provide details about your design. Include any specific instructions, color preferences, placement details, or other important information..."
                                    x-on:input="charCount = $event.target.value.length"
                                ></textarea>
                                <div class="flex justify-end mt-2">
                                    <span class="text-sm text-gray-500"><span x-text="charCount"></span>/<span x-text="maxChars"></span> characters</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reference Images Upload -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-gilroy font-bold text-lg text-gray-900">Reference Images</h3>
                        </div>
                        
                        <div class="p-6">
                            <label class="flex flex-col gap-y-4 p-6 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer bg-gray-50 text-center">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-purple-50 text-cPrimary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="space-y-1 text-center">
                                    <p class="font-medium text-gray-900">Upload reference images</p>
                                    <p class="text-sm text-gray-500">
                                        Drag and drop image files, or click to select files.<br>
                                        JPG, PNG up to 100MB each
                                    </p>
                                </div>
                                <input type="file" name="media[]" id="media" multiple class="hidden">
                                <div id="previewContainer" class="flex flex-wrap gap-4 justify-center mt-4">
                                    <!-- Preview images will appear here -->
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Order Details -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-gilroy font-bold text-lg text-gray-900">Order Details</h3>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Order Type -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Order Type</h4>
                                <div class="space-y-3">
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-cPrimary transition-colors">
                                        <input id="single" type="radio" name="order_type" value="single" class="mt-0.5 form-radio border-gray-300 text-cPrimary focus:ring-cPrimary" checked>
                                        <div class="ml-3">
                                            <span class="block font-medium text-gray-900">Single Order</span>
                                            <span class="text-sm text-gray-500">Perfect for personal use or as a unique gift</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-cPrimary transition-colors">
                                        <input id="bulk" type="radio" name="order_type" value="bulk" class="mt-0.5 form-radio border-gray-300 text-cPrimary focus:ring-cPrimary">
                                        <div class="ml-3">
                                            <span class="block font-medium text-gray-900">Bulk Order</span>
                                            <span class="text-sm text-gray-500">Minimum 10 pieces, ideal for teams and events</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Quantity -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Quantity</h4>
                                <div class="flex items-center">
                                    <div class="max-w-[120px]">
                                        <div class="flex items-center border border-gray-300 rounded-md">
                                            <button type="button" id="decrease-quantity" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" id="quantity" min="1" value="1" class="w-full h-10 text-center border-x border-gray-300 focus:ring-0 focus:outline-none">
                                            <button type="button" id="increase-quantity" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p id="bulk-quantity-message" class="ml-3 text-sm text-cPrimary font-medium hidden">
                                        Minimum 10 items required for bulk orders
                                    </p>
                                </div>
                                @error('quantity')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Customization Type -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Customization Type</h4>
                                <div class="space-y-3">
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-cPrimary transition-colors">
                                        <input id="standard" type="radio" name="custom_type" value="standard" class="mt-0.5 form-radio border-gray-300 text-cPrimary focus:ring-cPrimary" checked>
                                        <div class="ml-3">
                                            <span class="block font-medium text-gray-900">Standard Customization</span>
                                            <span class="text-sm text-gray-500">Same design for all items in your order</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-cPrimary transition-colors">
                                        <input id="personalized" type="radio" name="custom_type" value="personalized" class="mt-0.5 form-radio border-gray-300 text-cPrimary focus:ring-cPrimary">
                                        <div class="ml-3">
                                            <span class="block font-medium text-gray-900">Personalized Customization</span>
                                            <span class="text-sm text-gray-500">Individual designs for each item (e.g., names, numbers)</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Navigation Buttons -->
                            <div class="pt-4 border-t border-gray-200 space-y-3">
                                <button type="submit" class="w-full bg-cPrimary hover:bg-purple-700 text-white text-base font-medium py-3 px-6 rounded-xl transition-all flex items-center justify-center">
                                    Continue to Review
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <a href="{{ route('customer.place-order.select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]) }}" class="w-full flex items-center justify-center py-3 px-6 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    @include('layout.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/fabric@latest/dist/index.min.js"></script>
    <!-- Quantity control script only, fabric.js functionality is imported via customize.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity control for order type
            const decreaseBtn = document.getElementById('decrease-quantity');
            const increaseBtn = document.getElementById('increase-quantity');
            const quantityInput = document.getElementById('quantity');
            const bulkRadio = document.getElementById('bulk');
            const singleRadio = document.getElementById('single');
            const bulkMessage = document.getElementById('bulk-quantity-message');
            
            function updateQuantityConstraints() {
                if (bulkRadio.checked) {
                    quantityInput.min = 10;
                    if (parseInt(quantityInput.value) < 10) {
                        quantityInput.value = 10;
                    }
                    bulkMessage.classList.remove('hidden');
                } else {
                    quantityInput.min = 1;
                    bulkMessage.classList.add('hidden');
                }
            }
            
            // Initial setup
            updateQuantityConstraints();
            
            // Decrease quantity
            decreaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                let min = parseInt(quantityInput.min);
                if (value > min) {
                    quantityInput.value = value - 1;
                }
            });
            
            // Increase quantity
            increaseBtn.addEventListener('click', function() {
                let value = parseInt(quantityInput.value);
                quantityInput.value = value + 1;
            });
            
            // Update constraints when order type changes
            bulkRadio.addEventListener('change', updateQuantityConstraints);
            singleRadio.addEventListener('change', updateQuantityConstraints);
            
            // Validate on input
            quantityInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                let min = parseInt(this.min);
                if (value < min) {
                    this.value = min;
                }
            });
            
            // Preview uploaded reference images
            document.getElementById('media').addEventListener('change', function(e) {
                const previewContainer = document.getElementById('previewContainer');
                previewContainer.innerHTML = '';
                
                if (e.target.files && e.target.files.length > 0) {
                    Array.from(e.target.files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const previewWrapper = document.createElement('div');
                                previewWrapper.className = 'relative group';
                                
                                const img = document.createElement('img');
                                img.src = event.target.result;
                                img.className = 'w-20 h-20 object-cover rounded-md border border-gray-200';
                                
                                previewWrapper.appendChild(img);
                                previewContainer.appendChild(previewWrapper);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>