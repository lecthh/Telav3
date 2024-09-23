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
    <div class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
        <div class="flex flex-col gap-y-10">
            @include('customer.place-order.steps')
            <div class="flex flex-col gap-y-3 animate-fade-in">
                <h1 class="font-gilroy font-bold text-5xl">Customize Your Apparel</h1>
                <p class="font-inter text-base">Now it's time to get creative! Add your unique design, choose your colors, and make any other custom adjustments to create something truly one-of-a-kind.</p>
            </div>
        </div>
        <div class="flex flex-col gap-y-10 font-inter animate-fade-in">
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Description</h3>
                <div class="flex flex-col gap-y-2" x-data="{ charCount: 0, maxChars: 500 }">
                    <textarea name="description" id="description" rows="3" class="w-full border border-black px-4 py-[18px] rounded-lg active:border-cPrimary focus:outline-none focus:border-cPrimary" placeholder="Please provide your design customization details, including preferred colors, patterns, artwork, logos, text, and any specific instructions for placement or modifications to the apparel..." x-on:input="charCount = $event.target.value.length"></textarea>
                    <div class="flex justify-end">
                        <h5 id="char_count" class="text-sm"><span x-text="charCount"></span>/<span x-text="maxChars"></span></h5>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Media</h3>
                <label class="flex flex-col gap-y-6 px-5 py-11 border border-black border-dashed rounded-lg items-center justify-center">
                    <input type="file" name="" id="" class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-cPrimary hover:file:bg-violet-100">
                    <h5 class="text-base">Upload your design image (JPEG, PNG). Maximum file size: 100MB.</h5>
                </label>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Order Type</h3>
                <fieldset class="flex flex-col gap-y-2">
                    <label class="flex items-center gap-x-2">
                        <input id="bulk" type="radio" name="order-type" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary "/>
                        Bulk Order (Min. of 10 pcs.)
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="single" type="radio" name="order-type" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary "/>
                        Single Order
                    </label>
                </fieldset>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Customization</h3>
                <fieldset class="flex flex-col gap-y-2">
                    <label class="flex items-center gap-x-2">
                        <input id="standard" type="radio" name="custom-type" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary "/>
                        Standard Customization
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="personalized" type="radio" name="custom-type" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary "/>
                        Personalized Customization
                    </label>
                </fieldset>
            </div>
        </div>
        <div class="flex justify-start gap-x-3">
            @livewire('button', ['style' => 'greyed', 'text' => 'Back'])
            @livewire('button', ['text' => 'Continue'])
        </div>
    </div>
    @include('layout.footer')
</body>

</html>