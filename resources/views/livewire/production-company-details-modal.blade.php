<div>
    @if($selectedItem && $showModal)
    <x-view-details-modal wire:model="showModal" title="Production Company Details">
        <div class="bg-white p-6 rounded-lg space-y-4">
            <!-- Company Logo -->
            <div class="flex justify-center">
                <img src="{{ $selectedItem->company_logo ? asset($selectedItem->company_logo) : asset('images/default.png') }}"
                    alt="Company Logo"
                    class="w-52 h-52 rounded-full object-cover">
            </div>
            <!-- Company Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Column 1: Company Name, Production Type, Address, Phone -->
                <div class="space-y-4">
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Company Name</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->company_name }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Production Type</h3>
                        <p class="text-base font-semibold">
                            {{ implode(', ', $selectedItem->getProductionTypeNames()) }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Address</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->address }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->phone }}</p>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Verified</h3>
                        <p class="text-base font-semibold">
                            @if($selectedItem->is_verified)
                            <span class="text-green-500">Verified</span>
                            @else
                            <span class="text-red-500">Not Verified</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Column 2: Average Rating, Review Count, Apparel Type, Email, User ID, Verified -->
                <div class="space-y-4">
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Average Rating</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->avg_rating }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Review Count</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->review_count }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Apparel Type</h3>
                        <p class="text-base font-semibold">
                            {{ implode(', ', $selectedItem->getApparelTypeNames()) }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->email }}</p>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-sm font-medium text-gray-500">User ID</h3>
                        <p class="text-base font-semibold">{{ $selectedItem->user_id }}</p>
                    </div>

                </div>

                <!-- Column 3: Business Documents -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Business Documents</h3>
                    <ul class="mt-2 space-y-2">
                        @foreach($selectedItem->businessDocuments as $document)
                        <li>
                            <a href="{{ asset('storage/' . $document->path) }}" download
                                class="flex items-center text-blue-600 hover:underline hover:bg-gray-100 px-2 py-1 rounded transition">
                                <span class="mr-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </span>
                                <span>{{ $document->name }}</span>
                            </a>
                        </li>
                        @endforeach
                        @if($selectedItem->businessDocuments->isEmpty())
                        <li class="text-gray-500">No documents available.</li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </x-view-details-modal>
    @endif
</div>