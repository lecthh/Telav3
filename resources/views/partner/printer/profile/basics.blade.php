<html>

<body class="flex flex-col h-full justify-between bg-gray-50">
    <div class="flex flex-col h-full">
        <div class="flex p-1.5 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">
            Production Hub
        </div>
        <div class="flex h-full">
            @include('layout.printer')
            
            <div class="flex flex-col gap-y-6 p-8 bg-[#F9F9F9] h-full w-full animate-fade-in">
                <div class="flex justify-between items-center">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Company Profile</h2>
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-200">
                        <ul class="flex gap-x-5 px-6">
                            <a href="{{ route('partner.printer.profile.basics') }}">
                                <li class="font-inter font-semibold text-base py-4 border-b-2 text-cPrimary border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer transition duration-150">
                                    Company Information
                                </li>
                            </a>
                            <a href="{{ route('partner.printer.profile.pricing') }}">
                                <li class="font-inter font-semibold text-base py-4 text-gray-600 hover:text-cPrimary hover:border-b-2 hover:border-cPrimary cursor-pointer transition duration-150">
                                    Pricing
                                </li>
                            </a>
                        </ul>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('partner.printer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            
                            <div class="flex flex-col md:flex-row gap-8">
                                <!-- Company Logo Section -->
                                <div class="flex flex-col gap-y-3 items-center justify-center">
                                    <h4 class="font-gilroy font-semibold text-gray-700 self-start mb-2">Company Logo</h4>
                                    <div class="relative group">
                                        <div class="w-40 h-40 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden">
                                            @if($productionCompany->company_logo && $productionCompany->company_logo != 'imgs/companyLogo/placeholder.jpg')
                                                <img id="logo-preview" src="{{ asset('storage/' . $productionCompany->company_logo) }}" alt="Company Logo" class="w-full h-full object-cover">
                                            @else
                                                <img id="logo-preview" src="{{ asset('imgs/companyLogo/placeholder.jpg') }}" alt="Company Logo" class="w-32 h-32 object-contain opacity-70">
                                            @endif
                                            
                                            <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">Change Logo</span>
                                            </div>
                                        </div>
                                        <input type="file" id="company_logo" name="company_logo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2 text-center max-w-xs">Upload a square image (PNG, JPG) for best results. Max size: 2MB.</p>
                                    
                                    @error('company_logo')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Company Details Section -->
                                <div class="flex flex-col gap-y-5 flex-1">
                                    <div class="flex flex-col gap-y-2">
                                        <label for="company_name" class="font-gilroy font-semibold text-gray-700">Company Name</label>
                                        <input 
                                            type="text" 
                                            id="company_name" 
                                            name="company_name" 
                                            class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary" 
                                            value="{{ old('company_name', $productionCompany->company_name) }}"
                                        >
                                        @error('company_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div class="flex flex-col gap-y-2">
                                            <label for="email" class="font-gilroy font-semibold text-gray-700">Email Address</label>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="email" 
                                                class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary" 
                                                value="{{ old('email', $productionCompany->email) }}"
                                            >
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div class="flex flex-col gap-y-2">
                                            <label for="phone" class="font-gilroy font-semibold text-gray-700">Contact Number</label>
                                            <input 
                                                type="tel" 
                                                id="phone" 
                                                name="phone" 
                                                class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary" 
                                                value="{{ old('phone', $productionCompany->phone) }}"
                                            >
                                            @error('phone')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col gap-y-2">
                                        <label for="address" class="font-gilroy font-semibold text-gray-700">Business Address</label>
                                        <textarea 
                                            id="address" 
                                            name="address" 
                                            rows="3" 
                                            class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary"
                                        >{{ old('address', $productionCompany->address) }}</textarea>
                                        @error('address')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-end">
                                <button 
                                    type="submit" 
                                    class="flex bg-cPrimary rounded-md text-white font-medium text-base px-6 py-3 justify-center transition duration-150 ease-in-out hover:bg-purple-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        // Logo preview functionality
        document.getElementById('company_logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('logo-preview').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>