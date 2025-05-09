<div id="producer-registration" class="py-4">
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <p class="font-medium">{{ session('message') }}</p>
    </div>
    @endif

    <form wire:submit.prevent="submit">
        <!-- Services Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Services Offered</h2>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Production Types</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="flex items-center p-3 bg-white border border-gray-300 rounded-md hover:border-purple-500 cursor-pointer transition-colors">
                        <input type="checkbox" id="sublimation" wire:model="production_type" value="1"
                            class="h-5 w-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        <span class="ml-3 text-gray-700">Sublimation</span>
                    </label>

                    <label class="flex items-center p-3 bg-white border border-gray-300 rounded-md hover:border-purple-500 cursor-pointer transition-colors">
                        <input type="checkbox" id="heat-transfer" wire:model="production_type" value="2"
                            class="h-5 w-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        <span class="ml-3 text-gray-700">Heat Transfer</span>
                    </label>

                    <label class="flex items-center p-3 bg-white border border-gray-300 rounded-md hover:border-purple-500 cursor-pointer transition-colors">
                        <input type="checkbox" id="embroidery" wire:model="production_type" value="3"
                            class="h-5 w-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        <span class="ml-3 text-gray-700">Embroidery</span>
                    </label>
                </div>
                @error('production_type')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Production Type Is Required
                </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Apparel Types</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($apparelTypes as $apparel_type)
                    <label class="flex items-center p-3 bg-white border border-gray-300 rounded-md hover:border-purple-500 cursor-pointer transition-colors">
                        <input type="checkbox" id="{{ $apparel_type->name }}" wire:model="apparel_type" value="{{ $apparel_type->id }}"
                            class="h-5 w-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        <span class="ml-3 text-gray-700">{{ $apparel_type->name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('apparel_type')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Apparel Types are Required
                </p>
                @enderror
            </div>
        </div>

        <!-- Company Information Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Company Information</h2>

            <div class="mb-5">
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm2 5h2v1H9v-1zm0 2h2v1H9v-1zm-2 1h6v1H7v-1zm2-8h2v1H9V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="company_name" wire:model="company_name"
                        class="pl-10 block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                        placeholder="Enter your company name">
                </div>
                @error('company_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input type="email" id="email" wire:model="email"
                            class="pl-10 block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="company@example.com">
                    </div>
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <input type="text" id="mobile" wire:model="mobile"
                            class="pl-10 block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="(123) 456-7890">
                    </div>
                    @error('mobile')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


            </div>
        </div>

        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                Business Documents
                <span class="ml-2">
                    <x-popover>
                        <x-slot name="trigger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </x-slot>
                        Please provide business verification documents (e.x. Business Tax Registration, Mayors Permit, Images of your Establishment etc..) to complete your registration.
                    </x-popover>
                </span>
            </h2>
            @foreach($documents as $index => $document)
            <div class="mb-4 flex gap-4 items-center">
                <div class="flex-1">
                    <label for="document-name-{{ $index }}" class="block text-sm font-medium text-gray-700">
                        Document Name
                    </label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg width="18" class="h-5 w-5 text-gray-400" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 10H5M7 14H5M13 6H5M17 5.8V16.2C17 17.8802 17 18.7202 16.673 19.362C16.3854 19.9265 15.9265 20.3854 15.362 20.673C14.7202 21 13.8802 21 12.2 21H5.8C4.11984 21 3.27976 21 2.63803 20.673C2.07354 20.3854 1.6146 19.9265 1.32698 19.362C1 18.7202 1 17.8802 1 16.2V5.8C1 4.11984 1 3.27976 1.32698 2.63803C1.6146 2.07354 2.07354 1.6146 2.63803 1.32698C3.27976 1 4.11984 1 5.8 1H12.2C13.8802 1 14.7202 1 15.362 1.32698C15.9265 1.6146 16.3854 2.07354 16.673 2.63803C17 3.27976 17 4.11984 17 5.8Z" stroke="grey" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <input
                            type="text"
                            id="document-name-{{ $index }}"
                            wire:model="documents.{{ $index }}.name"
                            class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="Enter document name">
                    </div>
                    @error("documents.$index.name")
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="document-file-{{ $index }}" class="block text-sm font-medium text-gray-700">
                        Upload Document
                    </label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg width="24" class="h-5 w-5 text-gray-400" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.1525 10.8995L12.1369 19.9151C10.0866 21.9653 6.7625 21.9653 4.71225 19.9151C2.662 17.8648 2.662 14.5407 4.71225 12.4904L13.7279 3.47483C15.0947 2.108 17.3108 2.108 18.6776 3.47483C20.0444 4.84167 20.0444 7.05775 18.6776 8.42458L10.0156 17.0866C9.33213 17.7701 8.22409 17.7701 7.54068 17.0866C6.85726 16.4032 6.85726 15.2952 7.54068 14.6118L15.1421 7.01037" stroke="grey" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </div>
                        <input
                            type="file"
                            id="document-file-{{ $index }}"
                            wire:model="documents.{{ $index }}.file"
                            accept="image/*,application/pdf"
                            class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cPrimary bg-white focus:border-cPrimary py-3">
                    </div>
                    @error("documents.$index.file")
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-center h-full mt-7">
                    @if(count($documents) > 1)
                    <button
                        type="button"
                        wire:click="removeDocument({{ $index }})"
                        class="border border-red-500 text-red-500 bg-transparent hover:bg-red-50 rounded-full w-6 h-6 flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 7L7 17M7 7L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
            <p class="mt-4 mb-4 text-sm text-gray-600">
                Accepted documents: PDF, JPG, JPEG, PNG. Maximum file size: 2 MB.
            </p>
            <button type="button" wire:click="addDocument"
                class="bg-blue-500 text-white px-4 py-2 rounded">
                Add Document
            </button>
        </div>


        <!-- Address Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Company Address</h2>

            <div class="mb-5">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="address" wire:model="address"
                        class="pl-10 block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                        placeholder="123 Business Ave, Suite 100">
                </div>
                @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                    <input type="text" id="state" wire:model="state"
                        class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                        placeholder="Enter State/Province">
                    @error('state')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" id="city" wire:model="city"
                        class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                        placeholder="Enter City">
                    @error('city')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code</label>
                    <input type="text" id="zip_code" wire:model="zip_code"
                        class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                        placeholder="12345">
                    @error('zip_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Agreement and Submit -->
        <div class="flex items-center mb-6">
            <input id="terms" type="checkbox" class="h-4 w-4 text-cPrimary focus:ring-cPrimary border-gray-300 rounded">
            <label for="terms" class="ml-2 block text-sm text-gray-700">
                I agree to the <a href="#" class="text-cPrimary hover:underline">Terms and Conditions</a> and <a href="#" class="text-cPrimary hover:underline">Privacy Policy</a>
            </label>
        </div>

        <button type="submit"
            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-cPrimary hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary transition-colors">
            <span>Register as Production Partner</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</div>