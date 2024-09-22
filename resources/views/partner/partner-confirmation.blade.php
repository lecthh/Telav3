<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen">
    @include('layout.nav')
    <div class="flex-grow flex items-center justify-center">
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-full max-w-[1500px]">
            <div class="flex flex-col gap-y-[50px] px-[50px] py-[60px]">
                <div class="flex flex-col gap-y-10">
                    <div class="flex flex-col gap-y-3">
                        <h1 class="font-gilroy font-bold text-3xl">Thank you for signing up with us!</h1>
                    </div>
                    <hr class="border-t-2 border-cSecondary w-full my-4">
                    <h2 class="font-inter text-lg">An email has been sent to you for confirmation and account setup.</h2>
                </div>
                <div class="flex flex-col gap-y-2.5 px-6 py-3.5">
                    @livewire('button', ['text' => 'Confirm'])
                </div>
            </div>
        </div>
    </div>
</body>

</html>