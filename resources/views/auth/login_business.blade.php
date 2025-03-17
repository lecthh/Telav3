<!DOCTYPE html>
<html lang="en">
@include('layout.auth_nav')

<body class="flex flex-col h-screen justify-between">


    <div class="flex flex-col justify-center items-center flex-grow animate-fade-in">
        <div class="relative">
            <div class="flex flex-col gap-x-[12px] text-center mb-5 relative">
                <h1 class="font-gilroy font-bold text-5xl mb-6 ">Welcome to Tel-a BusinessHub</h1>
                <p class="font-inter font-medium text-[18px]">Gain access to your personalized dashboard and manage your business.</p>
            </div>
        </div>
        <div class="w-full max-w-lg p-10 space-y-8 relative">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block mb-3 text-[18px] font-bold font-inter">Email</label>
                        <input type="email" id="email" name="email" class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-3 text-[18px] font-bold font-inter">Password</label>
                        <input type="password" id="password" name="password" class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required />
                    </div>
                    @if($errors->has('email'))
                    <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div>
                    <button type="submit" class="w-full flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Log In
                    </button>
                </div>
            </form>
        </div>
    </div>
    @include('layout.footer')
</body>


</html>