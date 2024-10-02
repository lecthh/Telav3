<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-start">
    @include('layout.nav')
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] h-full animate-fade-in">
        <div class="flex flex-col gap-y-8">
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-col gap-y-1">
                    <h4 class="font-gilroy font-bold text-lg">Person I am Chatting with</h4>
                    <h4 class="font-gilroy font-semibold text-sm text-cDarkGrey">Order no. 3981</h4>
                </div>
                <hr>
            </div>
            <div class="flex flex-col gap-y-8">
                <div class="flex flex-col gap-y-4">
                    <div class="flex gap-x-3 p-3 text-start justify-start">
                        <div class="flex">
                            <div class="w-[52px] h-[52px] bg-cAccent rounded-full"></div>
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex gap-x-3">
                                <h4 class="font-gilroy font-bold text-base">Person I am Chatting with</h4>
                                <h4 class="font-gilroy font-bold text-base text-cDarkGrey">1:27 PM</h4>
                            </div>
                            <p>Hi Jane, I’ve illustrated your idea and created the first draft based on the customization details you provided during your order. Does this align with your vision? Are there any revisions you’d like to make?</p>
                        </div>
                    </div>
                    <div class="flex gap-x-3 p-3 justify-end">
                        <div class="flex flex-col gap-y-2 w-[815px] p-3 bg-cPrimary rounded-lg text-white">
                            <p>Hi Jane, I’ve illustrated your idea and created the first draft based on the customization details you provided during your order. Does this align with your vision? Are there any revisions you’d like to make?</p>
                        </div>
                    </div>
                    <div class="flex gap-x-3 p-3 text-start justify-start">
                        <div class="flex">
                            <div class="w-[52px] h-[52px] bg-cAccent rounded-full"></div>
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex gap-x-3">
                                <h4 class="font-gilroy font-bold text-base">Person I am Chatting with</h4>
                                <h4 class="font-gilroy font-bold text-base text-cDarkGrey">1:27 PM</h4>
                            </div>
                            <p>Hi Jane, I’ve illustrated your idea and created the first draft based on the customization details you provided during your order. Does this align with your vision? Are there any revisions you’d like to make? Please check image attached below</p>
                            <div class="flex gap-x-3 p-3 bg-cAccent bg-opacity-20 rounded-lg w-[400px] h-[200px] cursor-pointer"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-y-3">
                    <input type="text" class="flex flex-col px-4 py-3 border border-gray-300 rounded-lg" placeholder="Send a message...">
                    <div class="flex gap-x-3 justify-end">
                        <button type="button" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                            Upload Image
                        </button>
                        <button type="button" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                            Send
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>

@include('layout.footer')

</html>