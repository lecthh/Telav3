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
                    <select wire:model="affiliated_producer" class="flex flex-row gap-y-2.5 px-5  border border-black rounded-lg h-[50px]">
                        <option value="">Select a producer</option>
                        @foreach($productionCompanies as $producer)
                        <option value="{{ $producer->id }}">{{ $producer->company_name }}</option>
                        @endforeach
                    </select>
                    @error('affiliated_producer') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div id="name-section" class="flex flex-col gap-y-2 flex-grow">
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
            <div class="flex flex-col gap-y-2.5">
                <button wire:click="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                    Continue
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleSections() {
        const affiliateYes = document.getElementById('affiliate-yes').checked;
        const producerSection = document.getElementById('producer-section');

        if (affiliateYes) {
            producerSection.style.display = 'block';
        } else {
            producerSection.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleSections();
    });
</script>