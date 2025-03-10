<div class="flex flex-col gap-y-[40px] w-full px-[24px] pt-[40px] pb-[40px] rounded-xl bg-white drop-shadow-md justify-center">
    <div class="flex flex-col gap-y-8">
        <div class="flex justify-between items-center">
            @if($isForgotPassword || $isSignup)
            <div class="cursor-pointer flex items-center gap-2" wire:click="goBack">
                @include('svgs.back')
            </div>
            @else
            <div></div>
            @endif
            <div class="cursor-pointer" wire:click="toggleModal">
                @include('svgs.delete')
            </div>
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
                Take your first steps by creating an account
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
                    placeholder="Enter your name" wire:model="name">
            </div>
            @endif

            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Email</h4>
                <input type="email" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter your email" wire:model="email" required>
                @error('email')
                <span class="text-red-500 text-sm" wire:key="email-error">{{ $message }}</span>
                @enderror
            </div>

            @if(!$isForgotPassword)
            <div class="flex flex-col gap-y-2">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Password</h4>
                <input type="password" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Create a password" wire:model="password">
                @if($isSignup)
                <span class=" text-Colors/Text/text-tertiary(600) text-sm">Must be at least 8 characters</span>
                @endif
            </div>
            @endif
            @if(!$isSignup && !$isForgotPassword)
            @error('login_error')
            <div class="text-red-500 text-sm text-start">
                {{ $message }}
            </div>
            @enderror
            @endif

            @if(!$isSignup)
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-x-2">
                    <input type="checkbox" id="remember-me" wire:model="rememberMe"
                        class="rounded border-gray-300 text-cPrimary focus:ring-cPrimary focus:border-cPrimary checked:border-cPrimary">
                    <label for="remember-me" class="text-sm text-gray-700">
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

        <div class="flex flex-col gap-y-4 font-inter justify-center items-center">
            @if($isForgotPassword)
            <button wire:click="sendPasswordResetLink" wire:loading.attr="disabled"
                class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center hover:bg-Primary/button-primary-bg_hover">

                <span wire:loading.remove wire:target="sendPasswordResetLink">Send Reset Link</span>
                <x-spinner wire:loading wire:target="sendPasswordResetLink" />
            </button>
            @else
            @if($isSignup)
            <button wire:click="register" wire:loading.attr="disabled"
                class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center hover:bg-Primary/button-primary-bg_hover">

                <span wire:loading.remove wire:target="register">Sign Up</span>
                <x-spinner wire:loading wire:target="register" />
            </button>
            @else
            <button wire:click="login" wire:loading.attr="disabled"
                class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center hover:bg-Primary/button-primary-bg_hover">

                <span wire:loading.remove wire:target="login">Continue with Email</span>
                <x-spinner wire:loading wire:target="login" />
            </button>
            @endif

            <a href="{{ route('google.redirect') }}"
                class="flex w-full rounded-md px-6 py-[14px] gap-x-3 bg-white border border-Colors/Border/border-primary text-black text-base items-center justify-center hover:bg-Colors/Background/bg-primary_hover">
                @include('svgs.google')
                {{ $isSignup ? 'Sign Up With Google' : 'Sign In With Google' }}
            </a>
            @endif

        </div>

        @if(!$isForgotPassword)
        <div class="text-center">
            <span class="text-sm cursor-pointer text-cPrimary hover:underline" wire:click="toggleSignup">
                {{ $isSignup ? 'Already have an account? Log in' : 'No account? Click here to sign up' }}
            </span>
        </div>
        @endif
    </div>
</div>