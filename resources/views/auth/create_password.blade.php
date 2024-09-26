<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between">
    @include('layout.auth_nav')

    <div class="flex justify-center items-center flex-grow">
        <div class="w-full max-w-lg p-10 space-y-8">
            <div class="flex flex-col gap-x-[12px] text-center mb-12">
                <h1 class="font-gilroy font-bold text-5xl mb-6">Create a Password</h1>
                <p class="font-inter font-medium text-[18px]">Please set your password to continue</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block mb-3 text-[18px] font-bold font-inter">Create Password</label>
                        <input type="password" id="password" name="password" class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-3 text-[18px] font-bold font-inter">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required />
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Set Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>