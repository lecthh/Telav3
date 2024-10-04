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
        <div class="flex flex-col gap-y-6">
            <h4 class="font-gilroy font-bold text-5xl">Inbox</h4>
            <h5>Hello, you have 2 unread messages.</h5>
        </div>
        <div class="flex flex-col gap-y-4">
            <div class="flex flex-col gap-y-4">
                <h3 class="font-gilroy font-bold text-2xl">Latest</h3>
                <hr>
            </div>
            <div class="flex flex-col gap-y-2">
                <div class="flex p-3 gap-x-[18px] cursor-pointer rounded-lg hover:bg-cAccent hover:bg-opacity-10">
                    <div class="flex gap-x-3 items-center justify-end">
                        <div class="w-3 h-3 bg-cPrimary rounded-full"></div>
                        <div class="w-[52px] h-[52px] bg-cAccent rounded-full"></div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <div class="flex gap-x-4 item-start justify-start">
                            <div class="flex flex-col">
                                <h5 class="font-gilroy font-bold text-base">EchoPoint Productions</h5>
                                <h6 class="font-gilroy font-semibold text-cDarkGrey text-sm">Order no. 9081</h6>
                            </div>
                            <h6 class="font-gilroy font-semibold text-cDarkGrey text-sm">3h</h6>
                        </div>
                        <h6 class="font-inter text-sm text-cDarkGrey">This is the first draft of the design...</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@include('layout.footer')

</html>