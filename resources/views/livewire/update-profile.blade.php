<form wire:submit.prevent="save" class="space-y-7">
    @csrf
    <div>
        <h2 class="font-inter font-bold text-lg pb-[16px]">Display Name</h2>
        <input type="text" id="display_name" name="display_name" class="w-full p-3 border border-black rounded-md" wire:model="name">
    </div>
    <div>
        <h2 class="font-inter font-bold text-lg pb-[16px]">Email</h2>
        <input type="email" id="email" name="email" class="w-full p-3 border border-black rounded-md" wire:model="email">
    </div>
    <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">Save</button>
    @if (session()->has('message'))
        <div class="text-green-500">
            {{ session('message') }}
        </div>
    @endif
</form>