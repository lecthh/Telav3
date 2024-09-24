<div id="producer-registration">
    @if (session()->has('message'))
    <div class="text-green-500 font-bold">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Please select the types of services you offer</h2>
                <div class="flex flex-row gap-x-8">
                    <div class="flex flex-row gap-x-3 items-center">
                        <input type="checkbox" id="sublimation" wire:model="production_type" value="sublimation" class="form-checkbox">
                        <label for="sublimation" class="font-inter text-base">Sublimation</label>
                    </div>
                    <div class="flex flex-row gap-x-3 items-center">
                        <input type="checkbox" id="heat-transfer" wire:model="production_type" value="heat-transfer" class="form-checkbox">
                        <label for="heat-transfer" class="font-inter text-base">Heat Transfer</label>
                    </div>
                    <div class="flex flex-row gap-x-3 items-center">
                        <input type="checkbox" id="embroidery" wire:model="production_type" value="embroidery" class="form-checkbox">
                        <label for="embroidery" class="font-inter text-base">Embroidery</label>
                    </div>
                </div>
                @error('production_type') <span class="text-red-500">Production Type Is Required</span> @enderror
            </div>
        </div>
        <br>

        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Please select the types of apparel you offer</h2>
                <div class="flex flex-row gap-x-8">
                    @foreach($apparelTypes as $apparel_type)

                    <div class="flex flex-row gap-x-3 items-center">
                        <input type="checkbox" id="{{ $apparel_type->name }}" wire:model="apparel_type" value="{{ $apparel_type->name }}" class="form-checkbox">
                        <label for="{{ $apparel_type->name }}" class="font-inter text-base">{{ $apparel_type->name }}</label>
                    </div>
                    @endforeach

                </div>
                @error('apparel_type') <span class="text-red-500">Apparel Types are Required</span> @enderror
            </div>
        </div>
        <br>

        <div class="flex flex-col gap-y-6 flex-grow">
            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Company name</h2>
                <div class="flex flex-col gap-y-2">
                    <input type="text" wire:model="company_name" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                    @error('company_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-row gap-x-6">
                <div class="flex flex-col gap-y-4 flex-grow">
                    <h2 class="font-inter font-bold text-lg">Email address</h2>
                    <div class="flex flex-col gap-y-2">
                        <input type="email" wire:model="email" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex flex-col gap-y-4 flex-grow">
                    <h2 class="font-inter font-bold text-lg">Mobile number</h2>
                    <div class="flex flex-col gap-y-2">
                        <input type="text" wire:model="mobile" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                        @error('mobile') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-y-4">
                <h2 class="font-inter font-bold text-lg">Address</h2>
                <div class="flex flex-col gap-y-2">
                    <input type="text" wire:model="address" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                    @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-row gap-x-6 flex-grow justify-between">
                <div class="flex flex-col gap-y-4 w-full">
                    <h2 class="font-inter font-bold text-lg">State/Province</h2>
                    <div class="flex flex-col gap-y-2">
                        <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full">
                            <input type="text" wire:model="state" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter State/Province">
                        </div>
                        @error('state') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-y-4 w-full">
                    <h2 class="font-inter font-bold text-lg">City</h2>
                    <div class="flex flex-col gap-y-2">
                        <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full">
                            <input type="text" wire:model="city" class="font-inter text-base border-none focus:ring-0 outline-none w-full" placeholder="Enter City">
                        </div>
                        @error('city') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-y-4 w-full">
                    <h2 class="font-inter font-bold text-lg">Zip Code</h2>
                    <div class="flex flex-col gap-y-2">
                        <input type="text" wire:model="zip_code" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full" />
                        @error('zip_code') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-x-3 items-start py-5">
                @livewire('button', ['text' => 'Submit'])
            </div>
        </div>
    </form>
</div>