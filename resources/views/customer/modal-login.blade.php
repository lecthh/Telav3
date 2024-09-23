<div class="flex flex-col gap-y-[60px] w-[612px] px-[50px] pt-[52px] pb-[100px] rounded-md bg-white drop-shadow-md justify-center">
    <div class="flex flex-col gap-y-8">
        <div class="flex justify-end">@include('svgs.delete')</div>
        <div class="flex flex-col gap-y-8 justify-center items-center">
            @include('svgs.logo')
            <h1 class="font-gilroy font-bold text-3xl">Log in or Sign Up</h1>
        </div>
    </div>
    <div class="flex flex-col gap-y-10 font-inter w-full">
        <div class="flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-3">
                <h4 class="font-bold text-lg">Email</h4>
                <input type="text" class="border border-black rounded-md px-5 py-4" placeholder="email@gmail.com">
            </div>
            <span class="items-center justify-center text-red hidden">Invalid email or password</span>
        </div>
        <div class="flex flex-col gap-y-4 font-inter justify-center items-center">
            <div class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center">
                Continue with Email
            </div>
            <span class="text-sm">or</span>
            <a wire:navigate href=" {{route('google.redirect') }} " class="flex w-full rounded-md px-6 py-[14px] gap-x-3 bg-white border border-black text-black text-base items-center justify-center">
                @include('svgs.google')
                Continue with Google
            </a>
        </div>
    </div>
</div>