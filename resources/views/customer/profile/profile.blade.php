<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between">
    <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[20px]">
        <div class="flex flex-col gap-y-[20px]">
            <h1 class="font-gilroy font-bold text-[48px] w-[447px]">Profile Page</h1>
            <div class="flex mb-6 gap-x-[20px]">
                <a href="#" class="font-inter text-[24px] font-bold text-purple-500 underline underline-offset-8 transition-colors duration-200 hover:text-purple-700">Basics</a>
                <a href="#" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-purple-500">Order</a>
                <a href="#" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-purple-500">Reviews</a>
            </div>
        </div>
        <div class="flex flex-col">
            <form action="" method="POST" class="space-y-7">
                @csrf
                <div>
                    <label for="display_name" class="block font-gilroy text-black font-bold mb-[16px] text-[18px] ">Display name</label>
                    <input type="text" id="display_name" name="display_name" class="w-full p-3 border border-gray-300 rounded-md" value="Jane">
                </div>
                <div>
                    <label for="email" class="block font-gilroy text-black font-bold mb-[16px] text-[18px]">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-md" value="jane@gmail.com">
                </div>
                <div>
                    <label for="mobile_no" class="block font-gilroy text-black font-bold mb-[16px] text-[18px]">Mobile no.</label>
                    <input type="tel" id="mobile_no" name="mobile_no" class="w-full p-3 border border-gray-300 rounded-md" value="+63 054 4802 094">
                </div>

                <div>
                    <div class="flex justify-start pt-[40px]">
                        @livewire('button', ['text' => 'Save'])
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>