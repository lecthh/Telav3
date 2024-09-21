<div class="w-[612px] flex flex-col px-[50px] pt-[52px] pb-[100px] gap-y-[60px] bg-white rounded-lg">
    <div class="flex flex-col gap-y-8">
        <div class="flex items-center justify-end">
            @include('svgs.delete')
        </div>
        <div class="flex flex-col gap-y-8 items-center justify-center">
            @include('svgs.logo')
            <h1 class="font-gilroy font-bold text-3xl">Log in or Sign Up</h1>
        </div>
    </div>
    <div class="flex flex-col gap-y-10 font-inter">
        <div class="flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-3">
                <h4 class="font-bold text-lg">Email</h4>
                <input type="email" class="flex gap-x-3 px-5 py-4 text-base rounded-xl border border-gray-500 focus:border-cPrimary focus:ring-1 focus:outline-none focus:ring-cPrimary" placeholder="your@email.com">
            </div>
            <div class="flex flex-col gap-y-3">
                <h4 class="font-bold text-lg">Password</h4>
                <input type="password" class="flex gap-x-3 px-5 py-4 text-base rounded-xl border border-gray-500 focus:border-cPrimary focus:ring-1 focus:outline-none focus:ring-cPrimary">
            </div>
            <span class="text-sm text-red-500 text-center">Invalid email or password</span>
        </div>
        <div class="flex flex-col gap-y-4">
            @livewire('button', ['text' => 'Continue with Email'])
            @livewire('button', ['style' => 'secondary_black', 'text' => 'Continue with Google', 'icon' => 'google'])
        </div>
    </div>
</div>
