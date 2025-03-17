<div id="designer-registration" class="py-4">
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <p class="font-medium">{{ session('message') }}</p>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">There are errors with your submission:</h3>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form wire:submit.prevent="submit">
        <!-- Affiliation Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Designer Affiliation</h2>

            <fieldset>
                <legend class="text-sm font-medium text-gray-700 mb-3">Are you affiliated with a producer that is currently partnered with us?</legend>
                <div class="flex space-x-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" id="affiliate-yes" name="affiliate" value="yes" wire:model="affiliate"
                            class="h-5 w-5 text-cPrimary border-gray-300 focus:ring-cPrimary" onclick="toggleSections()">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" id="affiliate-no" name="affiliate" value="no" wire:model="affiliate"
                            class="h-5 w-5 text-cPrimary border-gray-300 focus:ring-cPrimary" onclick="toggleSections()">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
            </fieldset>

            <div id="producer-section" class="mt-6 transition-all duration-300" x-data="{ showSection: @entangle('affiliate').defer === 'yes' }"
                x-show="showSection" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">
                <label for="affiliated_producer" class="block text-sm font-medium text-gray-700 mb-1">Select Your Production Partner</label>
                <div class="relative">
                    <select id="affiliated_producer" wire:model="affiliated_producer"
                        class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-cPrimary focus:border-cPrimary rounded-md appearance-none">
                        <option value="">Select a production company</option>
                        @foreach($productionCompanies as $producer)
                        <option value="{{ $producer->id }}">{{ $producer->company_name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('affiliated_producer')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Designer Information</h2>

            <div id="name-section" class="mb-6">
                <div class="mb-5">
                    <label for="display_name" class="block text-sm font-medium text-gray-700 mb-1">Designer Display Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="display_name" wire:model="display_name"
                            class="pl-10 block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="How you'll appear to clients">
                    </div>
                    @error('display_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" id="first_name" wire:model="first_name"
                            class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="Enter your first name">
                        @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" id="last_name" wire:model="last_name"
                            class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary py-3"
                            placeholder="Enter your last name">
                        @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

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
                        placeholder="you@example.com">
                </div>
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Portfolio Section (Optional) -->
        <div class="mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Portfolio & Skills</h2>

            <div class="mb-5">
                <label for="design_experience" class="block text-sm font-medium text-gray-700 mb-1">Design Experience</label>
                <select id="design_experience" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-cPrimary focus:border-cPrimary rounded-md">
                    <option value="">Select your experience level</option>
                    <option value="beginner">Beginner (0-2 years)</option>
                    <option value="intermediate">Intermediate (2-5 years)</option>
                    <option value="advanced">Advanced (5+ years)</option>
                </select>
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Designer Bio</label>
                <textarea id="bio" rows="3" class="block w-full shadow-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary"
                    placeholder="Tell clients about your design experience and specialties..."></textarea>
                <p class="mt-1 text-xs text-gray-500">This will be displayed on your public profile (optional)</p>
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
            <span>Register as Designer</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        toggleSections();

        // Listen for Livewire updates
        if (typeof Livewire !== 'undefined') {
            Livewire.on('updated', () => {
                toggleSections();
            });
        }
    });

    function toggleSections() {
        const affiliateYes = document.getElementById('affiliate-yes');
        if (!affiliateYes) return;

        const isAffiliated = affiliateYes.checked;
        const producerSection = document.getElementById('producer-section');

        if (producerSection) {
            producerSection.style.display = isAffiliated ? 'block' : 'none';
        }
    }
</script>