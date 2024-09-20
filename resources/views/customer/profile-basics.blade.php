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

<body>
    @livewire('navigation-bar')
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
        <div class="flex flex-col gap-y-5">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
            </div>

            <!-- GAP-X-5 NOT GIVING SPACING FOR SOME REASON -->
            <div class="flex flex-row gap-x-5 ">
                <div class="flex flex-row gap-x-[60px] py-3">
                    <h1 class="font-inter font-bold text-2xl text-cPrimary">Basics</h1>
                </div>
                <div class="flex flex-row gap-x-[60px] py-3">
                    <h1 class="font-inter font-bold text-2xl">Orders</h1>
                </div>
                <div class="flex flex-row gap-x-[60px] py-3">
                    <h1 class="font-inter font-bold text-2xl">Reviews</h1>
                </div>                                
            </div>
        </div>

        <div class="flex flex-col gap-y-6"></div>
</body>


</html>