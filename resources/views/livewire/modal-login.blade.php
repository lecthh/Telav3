<div class="flex flex-col gap-y-[40px] w-full px-[24px] pt-[40px] pb-[40px] rounded-xl bg-white drop-shadow-md justify-center">
    <div class="flex flex-col gap-y-8">
        <div class="flex justify-end cursor-pointer" wire:click="$emit('closeModal')">
            @include('svgs.delete')
        </div>
        <div class="flex flex-col gap-y-1 justify-center items-center">
            @include('svgs.logo')
            <h1 class="font-inter text-lg font-semibold text-Colors/Text/text-primary(900)">
                @if($isForgotPassword)
                Forgot Password
                @elseif($isSignup)
                Create an account
                @else
                Log into your account
                @endif
            </h1>
            <span class="font-inter text-sm font-normal text-Colors/Text/text-tertiary(600)">
                @if($isForgotPassword)
                Enter your email to reset your password
                @elseif($isSignup)
                Create an account
                @else
                Welcome back! Please enter your details
                @endif
            </span>
        </div>
    </div>

    <div class="flex flex-col gap-y-10 font-inter w-full">
        @if($passwordResetStatus)
        <div class="text-green-600 text-center">
            {{ $passwordResetStatus }}
        </div>
        @else
        <div class="flex flex-col gap-y-5">
            @if($isSignup)
            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Name</h4>
                <input type="text" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter your first name" wire:model="first_name">
            </div>
            @endif

            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Email</h4>
                <input type="text" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="email@gmail.com" wire:model="email">
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @if(!$isForgotPassword)
            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Password</h4>
                <input type="password" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter password" wire:model="password">
            </div>

            @if(!$isSignup)
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-x-2">
                    <input type="checkbox" id="remember-me" wire:model="rememberMe"
                        class="rounded border-cPrimary text-cPrimary focus:ring-cPrimary focus:border-cPrimary checked:border-cPrimary">
                    <label for="remember-me" class="text-sm text-Colors/Text/text-secondary(700)">
                        Remember me for 30 days
                    </label>
                </div>
                <a href="#" wire:click.prevent="showForgotPassword"
                    class="text-sm text-cPrimary hover:underline">
                    Forgot Password?
                </a>
            </div>
            @endif
            @endif
        </div>
        @endif

        <div class="flex flex-col gap-y-4 font-inter justify-center items-center">
            @if($isForgotPassword)
            <button wire:click="sendPasswordResetLink"
                class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center">
                Send Reset Link
            </button>
            @else
            <button class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center">
                {{ $isSignup ? 'Sign Up' : 'Continue with Email' }}
            </button>
            <a href="{{ route('google.redirect') }}"
                class="flex w-full rounded-md px-6 py-[14px] gap-x-3 bg-white border border-black text-black text-base items-center justify-center">
                @include('svgs.google')
                {{ $isSignup ? 'Sign Up With Google' : 'Sign In With Google' }}
            </a>
            @endif
        </div>

        @if(!$isForgotPassword)
        <div class="text-center">
            <span class="text-sm cursor-pointer text-cPrimary" wire:click="toggleSignup">
                {{ $isSignup ? 'Already have an account? Log in' : 'No account? Click here to sign up' }}
            </span>
        </div>
        @endif
    </div>
</div>