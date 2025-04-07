<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="User Profile">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- User Header with Avatar and Key Info -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-t-lg border-b border-gray-200">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <img src="{{ $selectedItem->avatar ? asset($selectedItem->avatar) : asset('images/default.png') }}"
                            alt="{{ $selectedItem->name }}"
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-gray-900 truncate">{{ $selectedItem->name }}</h2>
                        <p class="text-sm text-gray-500 truncate">{{ $selectedItem->email }}</p>
                        <div class="flex items-center mt-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedItem->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($selectedItem->status) }}
                            </span>
                            @if($selectedItem->email_verified_at)
                            <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Verified Account
                            </span>
                            @else
                            <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                Unverified Email
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-6 px-6" aria-label="User Profile Tabs">
                    <button type="button"
                        wire:click="$set('activeTab', 'profile')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'profile' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'profile' ? 'page' : 'false' }}">
                        Profile Details
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'orders')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'orders' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'orders' ? 'page' : 'false' }}">
                        Orders History
                    </button>
                    <button type="button"
                        wire:click="$set('activeTab', 'address')"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out {{ $activeTab === 'address' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="{{ $activeTab === 'address' ? 'page' : 'false' }}">
                        Address Information
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                @if(!isset($activeTab) || $activeTab === 'profile')
                <!-- User Profile Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Account Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">User ID</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->user_id }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Full Name</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Email Address</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->email }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Contact Number</span>
                                    <span class="block text-sm font-medium text-gray-900">{{ $selectedItem->addressInformation->phone_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Account Status</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Email Verification</span>
                                    <span class="block text-sm font-medium {{ $selectedItem->email_verified_at ? 'text-green-600' : 'text-amber-600' }}">
                                        @if($selectedItem->email_verified_at)
                                        Verified on {{ $selectedItem->email_verified_at->format('M d, Y') }}
                                        @else
                                        Not verified
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Account Status</span>
                                    <span class="block text-sm font-medium {{ $selectedItem->isActive() ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($selectedItem->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Member Since</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->created_at->format('M d, Y') }}
                                        <span class="text-xs text-gray-500">({{ $selectedItem->created_at->diffForHumans() }})</span>
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">Last Updated</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($activeTab === 'orders')
                <!-- Orders History -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Recent Orders</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $selectedItem->orders->count() }} Orders
                        </span>
                    </div>

                    @if($selectedItem->orders->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($selectedItem->orders->take(5) as $order)
                                <tr class="hover:bg-gray-50 hover:cursor-pointer" wire:click="onRowClick('{{ $order->order_id }}')">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $order->order_id }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                            $order->status->status_id >= 1 && $order->status->status_id != 8 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800' 
                                            }}">
                                            {{ $order->status->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($order->final_price - $order->downpayment_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500">This user hasn't placed any orders yet.</p>
                    </div>
                    @endif
                </div>
                @elseif($activeTab === 'address')
                <!-- Address Information -->
                <div>
                    @if($selectedItem->addressInformation)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Shipping Address</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="block text-xs text-gray-500">Full Address</span>
                                <span class="block text-sm font-medium text-gray-900">
                                    {{ $selectedItem->addressInformation->full_address }}
                                </span>

                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="block text-xs text-gray-500">City</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->addressInformation->city }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500">State/Province</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->addressInformation->state }}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="block text-xs text-gray-500">Postal Code</span>
                                    <span class="block text-sm font-medium text-gray-900">
                                        {{ $selectedItem->addressInformation->zip_code }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500">Phone Number</span>
                                <span class="block text-sm font-medium text-gray-900">
                                    {{ $selectedItem->addressInformation->phone_number ?? 'Not provided' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No address information</h3>
                        <p class="mt-1 text-sm text-gray-500">This user hasn't added an address yet.</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </x-view-details-modal>
    @endif
</div>