<div id="designer-registration">
    @if (session()->has('message'))
    <div class="text-green-500 font-bold">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="flex flex-col gap-y-4">
            <h2 class="font-inter font-bold text-lg">Are you affiliated with a producer that is currently partnered with us?</h2>
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-row gap-x-8">
                    <div class="flex flex-row gap-x-2 items-center">
                        <input type="radio" id="affiliate-yes" name="affiliate" value="yes" class="form-radio border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary" onclick="toggleSections()" checked>
                        <label for="affiliate-yes" class="font-inter text-base">Yes</label>
                    </div>
                    <div class="flex flex-row gap-x-2 items-center">
                        <input type="radio" id="affiliate-no" name="affiliate" value="no" class="form-radio border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary" onclick="toggleSections()">
                        <label for="affiliate-no" class="font-inter text-base">No</label>
                    </div>                  
                </div>
            </div>
        </div>
        <br>

        <div id="producer-section" class="flex flex-col gap-y-4 flex-grow" style="display: none;">
            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Please select a producer</h2>
                <div class="flex flex-col gap-y-2">
                    <input type="text" wire:model="affiliated_producer" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                    @error('affiliated_producer') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div id="name-section" class="flex flex-col gap-y-6 flex-grow" style="display: none;">
            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Display name</h2>
                <div class="flex flex-col gap-y-2">
                    <input type="text" wire:model="display_name" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                    @error('display_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <br>
            <div class="flex flex-row gap-x-6">
                <div class="flex flex-col gap-y-4 flex-grow">
                    <h2 class="font-inter font-bold text-lg">First name</h2>
                    <div class="flex flex-col gap-y-2">
                        <input type="text" wire:model="first_name" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                        @error('first_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 flex-grow">
                    <h2 class="font-inter font-bold text-lg">Last name</h2>
                    <div class="flex flex-col gap-y-2">
                        <input type="text" wire:model="last_name" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                        @error('last_name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <br>       

        <div class="flex flex-col gap-y-4">
            <h2 class="font-inter font-bold text-lg">Email address</h2>
            <input type="text" wire:model="email" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
            @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <br><br>
        
        <div class="flex flex-row gap-x-3 h-[50px]">
            <div class="flex flex-col gap-y-2.5 px-6 py-3.5 rounded-lg bg-[rgba(156,163,175,0.21)]">
                <h2 class="font-inter text-lg text-[rgba(0,0,0,0.5)]">Cancel</h2>
            </div>
            <div class="flex flex-col gap-y-2.5">
                @livewire('button', ['text' => 'Checkout'])
            </div>            
        </div>

    </form>
</div>

<script>
    function toggleSections() {
        const affiliateYes = document.getElementById('affiliate-yes').checked;
        const producerSection = document.getElementById('producer-section');
        const nameSection = document.getElementById('name-section');

        if (affiliateYes) {
            producerSection.style.display = 'block';
            nameSection.style.display = 'none';
        } else {
            producerSection.style.display = 'none';
            nameSection.style.display = 'block';
        }
    }

    // Initialize the sections based on the default selection
    document.addEventListener('DOMContentLoaded', function() {
        toggleSections();
    });
</script>