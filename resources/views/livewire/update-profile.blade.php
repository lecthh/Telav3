<div>
    <form wire:submit.prevent="save" class="space-y-6">
        @csrf
        <div class="space-y-2">
            <label for="display_name" class="block font-inter font-medium text-gray-800 text-base">
                Display Name
            </label>
            <div class="relative">
                <input 
                    type="text" 
                    id="display_name" 
                    name="display_name" 
                    wire:model="name"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cPrimary focus:border-cPrimary transition duration-150"
                    placeholder="Enter your display name"
                >
            </div>
            @error('name') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="email" class="block font-inter font-medium text-gray-800 text-base">
                Email Address
            </label>
            <div class="relative">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    wire:model="email"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cPrimary focus:border-cPrimary transition duration-150"
                    placeholder="Enter your email address"
                >
            </div>
            @error('email') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button 
                type="submit" 
                class="flex items-center justify-center bg-cPrimary rounded-xl text-white text-lg px-8 py-3 transition ease-in-out hover:bg-purple-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Save Changes</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>
            </button>
        </div>

        @if (session()->has('message'))
            <div class="mt-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
                <svg class="h-5 w-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>