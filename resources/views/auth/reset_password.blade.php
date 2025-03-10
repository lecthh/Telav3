<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <meta name="description" content="Reset your password to continue.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between">
    <header>
        @include('layout.auth_nav')
    </header>

    <main class="flex justify-center items-center flex-grow">
        <div class="w-full max-w-lg p-10 space-y-8">
            <div class="text-center mb-12">
                <h1 class="font-gilroy font-bold text-5xl mb-6">Reset Your Password</h1>
                <p class="font-inter font-medium text-lg">Please set your password to continue</p>
            </div>

            <!-- Generic Error Block -->
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="space-y-4">
                    <div>
                        <label for="password" class="block mb-3 text-lg font-bold font-inter">Create Password</label>
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required>
                        @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-3 text-lg font-bold font-inter">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                            class="w-full h-14 px-4 py-2 border border-black rounded-lg focus:outline-none focus:border-purple-500" required>
                        @error('password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-cPrimary rounded-xl text-white text-lg px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Set Password
                    </button>
                </div>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-cPrimary underline hover:text-purple-500">
                    Remembered your password? Log in
                </a>
            </div>
        </div>
    </main>

    <footer>
        @include('layout.footer')
    </footer>
</body>

</html>