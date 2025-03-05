<div class="flex flex-col gap-y-[40px] w-fill px-[50px] pt-[52px] pb-[100px] rounded-md bg-white drop-shadow-md justify-center">
    <div class="flex flex-col gap-y-8">
        <div class="flex justify-end cursor-pointer" wire:click="$emit('closeModal')">
            @include('svgs.delete')
        </div>
        <div class="flex flex-col gap-y-1 justify-center items-center">
            @include('svgs.logo')
            <h1 class="font-inter text-lg font-semibold text-Colors/Text/text-primary(900)">
                {{ $isSignup ? 'Sign Up' : 'Log into your account' }}
            </h1>
            <span class="font-inter text-sm font-normal text-Colors/Text/text-tertiary(600) ">Welcome back! Please enter your details</span>
        </div>
    </div>

    <div class="flex flex-col gap-y-10 font-inter w-full">
        <div class="flex flex-col gap-y-5">
            @if($isSignup)
            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Name</h4>
                <input type="text" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter your first name" wire:model="name">
            </div>
            @endif

            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Email</h4>
                <input type="text" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="email@gmail.com" wire:model="email">
            </div>

            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Password</h4>
                <input type="password" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter password" wire:model="password">
            </div>
            <span class="items-center justify-center text-red hidden">
                Invalid email or password
            </span>
        </div>

        <div class="flex flex-col gap-y-4 font-inter justify-center items-center">
            <button class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center">
                {{ $isSignup ? 'Sign Up' : 'Continue with Email' }}
            </button>
            <span class="text-sm">or</span>
            <a href="{{ route('google.redirect') }}"
                class="flex w-full rounded-md px-6 py-[14px] gap-x-3 bg-white border border-black text-black text-base items-center justify-center">
                @include('svgs.google')
                Continue with Google
            </a>
        </div>

        <div class="text-center">
            <span class="text-sm cursor-pointer text-cPrimary" wire:click="toggleSignup">
                {{ $isSignup ? 'Already have an account? Log in' : 'No account? Click here to sign up' }}
            </span>
        </div>
    </div>
</div>