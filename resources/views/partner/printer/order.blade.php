<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="flex flex-col h-screen justify-between bg-gray-50">
    @include('chat.chat-widget')
    <div class="flex flex-col">
        <div class="flex p-1.5 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex">
            @include('layout.printer')
            <div class="flex flex-col gap-y-6 p-8 bg-[#F9F9F9] w-full">
                <!-- Header Section -->
                <div class="flex flex-col gap-y-5">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Orders</h1>
                        </div>
                        <a href="{{ route('partner.printer.orders') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Orders
                        </a>
                    </div>

                    @include('partner.printer.order-nav')
                </div>

                <!-- Order Header -->
                <div class="flex items-center justify-between bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <h1 class="font-gilroy font-bold text-xl text-gray-900">
                            Order No. {{$order->order_id}}
                        </h1>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $order->form_filled ? 'Ready for Production' : 'Waiting for Customization Form' }}
                        </span>
                    </div>
                    <x-popover>
                        <x-slot name="trigger">
                            <x-start-chat :user="$order->user" />
                        </x-slot>
                        Start chatting with {{ $order->user->name }}
                    </x-popover>
                </div>

                <!-- Main Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Customer Information Column -->
                    <div class="flex flex-col gap-y-1 col-span-1">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <!-- Customer Information -->
                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.calendar')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Date Requested</h4>
                                        <p class="font-inter text-base text-gray-900">{{ $order->created_at->format('F j, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.user-single')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Customer Name</h4>
                                        <p class="font-inter text-base text-gray-900">{{$order->user->name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.email')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Email</h4>
                                        <p class="font-inter text-base text-gray-900 break-words">{{$order->user->email}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.shirt')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Apparel Type</h4>
                                        <p class="font-inter text-base text-gray-900">{{$order->apparelType->name}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.receipt-check')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Order Type</h4>
                                        <p class="font-inter text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->is_bulk_order ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $order->is_bulk_order ? 'Bulk' : 'Single' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-l-4 border-cPrimary">
                                <div class="flex gap-x-4 p-4 bg-white">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cPrimary bg-opacity-10 flex-shrink-0">
                                        @include('svgs.paintbrush')
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 class="font-inter font-bold text-sm text-gray-700">Customization</h4>
                                        <p class="font-inter text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->is_customized ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $order->is_customized ? 'Personalized' : 'Standard' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <div class="bg-white rounded-lg shadow-sm mt-6">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Actions</h3>
                            </div>
                            <div class="p-4">
                                <form action="{{ route('partner.printer.cancel-order', ['order_id' => $order->order_id]) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to cancel this order?')" class="w-full flex justify-center items-center px-4 py-3 bg-red-500 hover:bg-red-600 rounded-lg text-white font-medium transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details & Designer Assignment Column -->
                    <div class="col-span-2 flex flex-col gap-y-6">
                        <!-- Order Specifications Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Order Specifications</h3>
                            </div>

                            <div class="p-4 border-b">
                                <h4 class="font-gilroy font-bold text-gray-900 text-base mb-3">Media</h4>
                                @if($order->imagesWithStatusOne->isEmpty())
                                <p class="text-gray-500 italic">No images uploaded</p>
                                @else
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($order->imagesWithStatusOne as $image)
                                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Order Image" class="w-full h-full object-cover">
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h4 class="font-gilroy font-bold text-gray-900 text-base mb-3">Description</h4>
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    @if(empty($order->custom_design_info))
                                    <p class="text-gray-500 italic">No description provided</p>
                                    @else
                                    <p class="font-inter text-gray-700 whitespace-pre-line">{{$order->custom_design_info}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Assign Designer Card -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="bg-cPrimary px-4 py-3 rounded-t-lg">
                                <h3 class="font-gilroy font-bold text-white text-base">Assign Designer</h3>
                            </div>

                            <div class="p-4">
                                <div class="mb-4">
                                    <div class="relative">
                                        <input type="text" id="designer-search" placeholder="Search designers..." class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-3 top-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="overflow-y-auto max-h-96 designer-container">
                                    @if($designers->isEmpty())
                                    <p class="text-gray-500 italic text-center py-6">No designers available</p>
                                    @else
                                    <form action="{{ route('partner.printer.assign-designer', ['order_id' => $order->order_id])}}" method="post" id="assign-designer-form">
                                        @csrf
                                        <input type="hidden" name="selected_designer_id" id="selected-designer-id" value="">

                                        <div id="designer-list" class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                            @foreach ($designers as $designer)
                                            <div class="border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-150 designer-item p-3 cursor-pointer"
                                                data-designer-id="{{ $designer->designer_id }}"
                                                data-designer-name="{{ $designer->user->name }}"
                                                onclick="selectDesigner(this)">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-12 h-12 rounded-full bg-cAccent overflow-hidden flex items-center justify-center">
                                                            @if($designer->profile_image)
                                                            <img src="{{ asset('storage/' . $designer->profile_image) }}"
                                                                alt="{{ $designer->user->name }}"
                                                                class="w-full h-full object-cover">
                                                            @else
                                                            <span class="text-lg font-bold text-white">{{ strtoupper(substr($designer->user->name, 0, 1)) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h3 class="font-gilroy font-bold text-gray-900">{{ $designer->user->name }}</h3>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $designer->productionCompany ? $designer->productionCompany->company_name : 'Freelancer' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="flex justify-end mt-4">
                                            <button type="submit" id="assign-btn" class="px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                                Assign Designer
                                            </button>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        // Designer selection
        function selectDesigner(selectedElement) {
            // Remove selection from all designers
            document.querySelectorAll('.designer-item').forEach(item => {
                item.classList.remove('ring-2', 'ring-cPrimary', 'bg-cAccent', 'bg-opacity-10');
                item.classList.add('border-gray-200');
            });

            // Add selection to clicked designer
            selectedElement.classList.remove('border-gray-200');
            selectedElement.classList.add('ring-2', 'ring-cPrimary', 'bg-cAccent', 'bg-opacity-10');

            // Update hidden input with selected designer ID
            const designerId = selectedElement.getAttribute('data-designer-id');
            document.getElementById('selected-designer-id').value = designerId;

            // Enable the assign button
            const assignBtn = document.getElementById('assign-btn');
            assignBtn.disabled = false;

            // Update button text
            const designerName = selectedElement.getAttribute('data-designer-name');
            assignBtn.innerHTML = `Assign ${designerName}`;
        }

        // Designer search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('designer-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const designers = document.querySelectorAll('.designer-item');

                    designers.forEach(designer => {
                        const designerName = designer.getAttribute('data-designer-name').toLowerCase();
                        if (designerName.includes(searchTerm)) {
                            designer.style.display = '';
                        } else {
                            designer.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>


</html>