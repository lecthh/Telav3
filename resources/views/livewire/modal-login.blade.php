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
            <!-- Email Input (common to both login and signup) -->
            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Email</h4>
                <input type="email"
                    class="border rounded-lg px-5 py-4 {{ $errors->has('login_error') ? 'border-red-500' : 'border-Colors/Border/border-primary' }} @if($isSignup && $signupStep == 3) bg-gray-100 cursor-not-allowed @endif"
                    placeholder="Enter your email"
                    wire:model="email" required
                    @if($isSignup && $signupStep==3) readonly @endif>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            @if($isSignup && $signupStep == 2)
            <div x-data="{

                        handlePaste(e) {
                            let paste = (e.clipboardData || window.clipboardData).getData('text').trim();
                            if (paste.length === 6 && /^\d+$/.test(paste)) {
                                $refs.code1.value = paste.charAt(0);
                                $refs.code2.value = paste.charAt(1);
                                $refs.code3.value = paste.charAt(2);
                                $refs.code4.value = paste.charAt(3);
                                $refs.code5.value = paste.charAt(4);
                                $refs.code6.value = paste.charAt(5);
                                @this.set('code1', paste.charAt(0));
                                @this.set('code2', paste.charAt(1));
                                @this.set('code3', paste.charAt(2));
                                @this.set('code4', paste.charAt(3));
                                @this.set('code5', paste.charAt(4));
                                @this.set('code6', paste.charAt(5));
                            }
                        },

                        handleBackspace(currentRef, previousRef) {
                            let currentInput = this.$refs[currentRef];
                            if (currentInput.value === '') {
                                let previousInput = this.$refs[previousRef];
                                if (previousInput) {
                                    previousInput.focus();
                                    previousInput.value = '';
                                    @this.set(previousRef, '');
                                }
                            }
                        },

                        handleInput(currentRef, nextRef) {
                            let currentInput = this.$refs[currentRef];
                            if (currentInput.value.length === 1 && nextRef) {
                                this.$refs[nextRef].focus();
                            }
                        }
                    }">
                <!-- The container listens for a paste event -->
                <div class="flex justify-center gap-x-2" @paste.prevent="handlePaste($event)">
                    <input type="text" maxlength="1" x-ref="code1" wire:model.defer="code1"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code1','code2')" autofocus>
                    <input type="text" maxlength="1" x-ref="code2" wire:model.defer="code2"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code2','code3')"
                        x-on:keydown.backspace="handleBackspace('code2','code1')">
                    <input type="text" maxlength="1" x-ref="code3" wire:model.defer="code3"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code3','code4')"
                        x-on:keydown.backspace="handleBackspace('code3','code2')">
                    <input type="text" maxlength="1" x-ref="code4" wire:model.defer="code4"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code4','code5')"
                        x-on:keydown.backspace="handleBackspace('code4','code3')">
                    <input type="text" maxlength="1" x-ref="code5" wire:model.defer="code5"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code5','code6')"
                        x-on:keydown.backspace="handleBackspace('code5','code4')">
                    <input type="text" maxlength="1" x-ref="code6" wire:model.defer="code6"
                        class="w-12 h-12 text-center border border-gray-300 rounded"
                        x-on:input="handleInput('code6', null)"
                        x-on:keydown.backspace="handleBackspace('code6','code5')">
                </div>

                <!-- Verification and Resend buttons -->
                <div class="flex flex-col items-center mt-4">
                    <button wire:click="verifyEmailCode"
                        wire:loading.attr="disabled"
                        wire:target="verifyEmailCode,resendEmailVerificationCode"
                        class="bg-cPrimary rounded-md px-6 py-3 text-white">
                        <span wire:loading.remove wire:target="verifyEmailCode,resendEmailVerificationCode">Verify Code</span>
                        <x-spinner wire:loading wire:target="verifyEmailCode,resendEmailVerificationCode" />
                    </button>
                    <button wire:click="resendEmailVerificationCode"
                        wire:loading.attr="disabled"
                        wire:target="verifyEmailCode,resendEmailVerificationCode"
                        class="mt-2 text-cPrimary hover:underline hover:bg-Primary/button-primary-bg_hover px-4 py-2">
                        Resend Code
                    </button>
                </div>
            </div>
            @endif

            <!-- For Signup Step 3: Name input -->
            @if($isSignup && $signupStep == 3)
            <div class="flex flex-col gap-y-3">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Name</h4>
                <input type="text" class="border border-Colors/Border/border-primary rounded-lg px-5 py-4"
                    placeholder="Enter your name" wire:model="name">
            </div>
            @endif

            <!-- Password Input (shown for both Login and Signup) -->
            @if(!$isForgotPassword && (!$isSignup || ($isSignup && $signupStep == 3)))
            <div class="flex flex-col gap-y-2" x-data="{ showPassword: false }">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Password</h4>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'"
                        class="border {{ $errors->has('login_error') ? 'border-red-500' : 'border-Colors/Border/border-primary' }} rounded-lg px-5 py-4 w-full"
                        placeholder="Create a password" wire:model="password">
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        x-on:click="showPassword = !showPassword">
                        <template x-if="!showPassword">
                            @include('svgs.eye')
                        </template>
                        <template x-if="showPassword">
                            @include('svgs.eye-off')
                        </template>
                    </button>
                </div>
                @if($isSignup)
                <span class="text-Colors/Text/text-tertiary(600) text-sm">Must be at least 8 characters</span>
                @endif
            </div>
            @endif


            @if($isSignup && $signupStep == 3)
            <div class="flex flex-col gap-y-2"
                x-data="{ 
             showConfirmPassword: false, 
             password: @entangle('password'), 
             password_confirmation: @entangle('password_confirmation') 
         }">
                <h4 class="font-medium text-sm text-Colors/Text/text-secondary(700)">Confirm Password</h4>
                <div class="relative">
                    <input :type="showConfirmPassword ? 'text' : 'password'"
                        class="border border-Colors/Border/border-primary rounded-lg px-5 py-4 w-full"
                        placeholder="Confirm your password" wire:model="password_confirmation">
                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                        x-on:click="showConfirmPassword = !showConfirmPassword">
                        <template x-if="!showConfirmPassword">
                            @include('svgs.eye')
                        </template>
                        <template x-if="showConfirmPassword">
                            @include('svgs.eye-off')
                        </template>
                    </button>
                </div>
                <template x-if="password && password_confirmation && password !== password_confirmation">
                    <span class="text-red-500 text-sm">Passwords do not match.</span>
                </template>
            </div>
            @endif


            <!-- Login-specific options -->
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
        </div>
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
        @if($signupStep == 1)
        <button wire:click="sendEmailVerificationCode" wire:loading.attr="disabled"
            class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center hover:bg-Primary/button-primary-bg_hover">
            <span wire:loading.remove wire:target="sendEmailVerificationCode">Send Verification Link</span>
            <x-spinner wire:loading wire:target="sendEmailVerificationCode" />
        </button>
        @elseif($signupStep == 3)
        <button wire:click="register" wire:loading.attr="disabled"
            class="flex w-full bg-cPrimary rounded-md px-6 py-[14px] text-white text-base items-center justify-center hover:bg-Primary/button-primary-bg_hover">
            <span wire:loading.remove wire:target="register">Sign Up</span>
            <x-spinner wire:loading wire:target="register" />
        </button>
        @endif
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