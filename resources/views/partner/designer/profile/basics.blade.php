<html>
<body class="min-h-screen flex flex-col bg-gray-50">
    <div class="flex p-1.5 bg-cGreen font-gilroy font-bold text-white text-sm justify-center">
        Designer Hub
    </div>
    
    <div class="flex flex-1">
        @include('layout.designer')
        
        <div class="flex flex-col flex-1 p-8 bg-[#F9F9F9] overflow-y-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="font-gilroy font-bold text-3xl text-black mb-4 sm:mb-0">Designer Profile</h2>
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative w-full sm:w-auto" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-8">
                <div class="p-6">
                    <form action="{{ route('partner.designer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Designer Details Section -->
                        <div class="flex flex-col gap-y-6 w-full">
                            <div class="flex flex-col gap-y-2">
                                <label for="name" class="font-gilroy font-semibold text-gray-700">Full Name</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full" 
                                    value="{{ old('name', $designer->user->name) }}"
                                >
                                @error('name')
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
                                        class="px-4 py-3 border border-gray-300 rounded-md bg-gray-100 w-full" 
                                        value="{{ $designer->user->email }}"
                                        disabled
                                    >
                                    <p class="text-xs text-gray-500">Email address cannot be changed</p>
                                </div>
                                
                                <!-- <div class="flex flex-col gap-y-2">
                                    <label for="phone" class="font-gilroy font-semibold text-gray-700">Contact Number</label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full" 
                                        value="{{ old('phone', $designer->user->phone) }}"
                                    >
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div> -->
                            </div>
                            
                            <div class="flex flex-col gap-y-2">
                                <label for="designer_description" class="font-gilroy font-semibold text-gray-700">Designer Bio/Description</label>
                                <textarea 
                                    id="designer_description" 
                                    name="designer_description" 
                                    rows="3" 
                                    class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full"
                                >{{ old('designer_description', $designer->designer_description) }}</textarea>
                                @error('designer_description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Designer Status Section -->
                        <div class="border-t border-gray-200 pt-6">
                            @if($designer->production_company_id)
                            <!-- Company-affiliated designer - just show status and company as text -->
                            <div class="flex flex-col space-y-4">
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500 mb-1 text-sm">Designer Status</p>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 bg-cGreen/10 text-cGreen text-sm font-medium rounded-md">Company-affiliated</span>
                                    </div>
                                    <input type="hidden" name="is_freelancer" value="0">
                                </div>
                                
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <p class="text-gray-500 mb-1 text-sm">Production Company</p>
                                    <p class="font-medium">{{ $designer->productionCompany->company_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">This association can only be changed by an administrator</p>
                                    <input type="hidden" name="production_company_id" value="{{ $designer->production_company_id }}">
                                </div>
                            </div>
                            @else
                            <div class="flex flex-col gap-y-2">
                                <label for="is_freelancer" class="font-gilroy font-semibold text-gray-700">Designer Status</label>
                                <select 
                                    id="is_freelancer" 
                                    name="is_freelancer" 
                                    class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full"
                                >
                                    <option value="1" {{ old('is_freelancer', $designer->is_freelancer) == 1 ? 'selected' : '' }}>Freelancer</option>
                                    <option value="0" {{ old('is_freelancer', $designer->is_freelancer) == 0 ? 'selected' : '' }}>Company-affiliated</option>
                                </select>
                                @error('is_freelancer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5" id="company-section" style="{{ old('is_freelancer', $designer->is_freelancer) == 0 ? '' : 'display: none;' }}">
                                <div class="flex flex-col gap-y-2">
                                    <label for="production_company_id" class="font-gilroy font-semibold text-gray-700">Production Company</label>
                                    <select 
                                        id="production_company_id" 
                                        name="production_company_id" 
                                        class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full"
                                    >
                                        <option value="">Select Production Company</option>
                                        @foreach($productionCompanies as $company)
                                            <option value="{{ $company->id }}" {{ old('production_company_id', $designer->production_company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500">Once affiliated with a company, this can only be changed by an administrator</p>
                                    @error('production_company_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            
                            @if(!$designer->production_company_id)
                            <!-- Design Services Section (only for freelancers/unaffiliated) -->
                            <div id="freelancer-services" style="{{ old('is_freelancer', $designer->is_freelancer) == 1 ? '' : 'display: none;' }}" class="mt-6 bg-white p-5 border border-gray-100 rounded-lg">
                                <h4 class="font-gilroy font-semibold text-lg text-gray-800 mb-4">Design Services</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="flex flex-col gap-y-2">
                                        <label for="talent_fee" class="font-gilroy font-semibold text-gray-700">Talent Fee (₱)</label>
                                        <input 
                                            type="number" 
                                            id="talent_fee" 
                                            name="talent_fee" 
                                            class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full" 
                                            value="{{ old('talent_fee', $designer->talent_fee) }}"
                                            min="0"
                                            step="0.01"
                                        >
                                        @error('talent_fee')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="flex flex-col gap-y-2">
                                        <label for="max_free_revisions" class="font-gilroy font-semibold text-gray-700">Maximum Free Revisions</label>
                                        <input 
                                            type="number" 
                                            id="max_free_revisions" 
                                            name="max_free_revisions" 
                                            class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full" 
                                            value="{{ old('max_free_revisions', $designer->max_free_revisions) }}"
                                            min="0"
                                            step="1"
                                        >
                                        @error('max_free_revisions')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="flex flex-col gap-y-2">
                                        <label for="addtl_revision_fee" class="font-gilroy font-semibold text-gray-700">Additional Revision Fee (₱)</label>
                                        <input 
                                            type="number" 
                                            id="addtl_revision_fee" 
                                            name="addtl_revision_fee" 
                                            class="px-4 py-3 border border-gray-300 rounded-md focus:ring-cGreen focus:border-cGreen w-full" 
                                            value="{{ old('addtl_revision_fee', $designer->addtl_revision_fee) }}"
                                            min="0"
                                            step="0.01"
                                        >
                                        @error('addtl_revision_fee')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @else
                            <!-- Hidden inputs for service fields for affiliated designers -->
                            <input type="hidden" name="talent_fee" value="{{ $designer->talent_fee }}">
                            <input type="hidden" name="max_free_revisions" value="{{ $designer->max_free_revisions }}">
                            <input type="hidden" name="addtl_revision_fee" value="{{ $designer->addtl_revision_fee }}">
                            @endif
                            
                            <!-- Availability (visible to all) -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 mb-2 text-sm">Designer Availability</p>
                                <div class="flex items-center gap-x-3">
                                    <input 
                                        type="checkbox" 
                                        id="is_available" 
                                        name="is_available" 
                                        class="rounded border-gray-300 text-cGreen focus:ring-cGreen h-5 w-5" 
                                        {{ old('is_available', $designer->is_available) ? 'checked' : '' }}
                                    >
                                    <label for="is_available" class="font-medium text-gray-700">Available for new design work</label>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">This status will be visible to production companies and customers</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <button 
                                type="submit" 
                                class="flex bg-cGreen rounded-md text-white font-medium text-base px-6 py-3 justify-center transition duration-150 ease-in-out hover:bg-green-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cGreen"
                            >
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('layout.footer')

    <script>
        const freelancerSelect = document.getElementById('is_freelancer');
        if (freelancerSelect) {
            freelancerSelect.addEventListener('change', function() {
                const companySection = document.getElementById('company-section');
                const freelancerServices = document.getElementById('freelancer-services');
                
                if (this.value === '1') { // Freelancer
                    if (companySection) companySection.style.display = 'none';
                    if (freelancerServices) freelancerServices.style.display = 'block';
                } else { // Company-affiliated
                    if (companySection) companySection.style.display = 'block';
                    if (freelancerServices) freelancerServices.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>