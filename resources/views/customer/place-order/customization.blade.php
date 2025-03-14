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
    @vite('resources/js/customize.js')
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between animate-fade-in">
    <form method="POST" action="{{ route('customer.place-order.customization-post', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) }}" enctype="multipart/form-data" class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
        @csrf
        <div class="flex flex-col gap-y-10">
            @include('customer.place-order.steps')
            <div class="flex flex-col gap-y-3 animate-fade-in">
                <h1 class="font-gilroy font-bold text-5xl">Customize Your Apparel</h1>
                <p class="font-inter text-base">Now it's time to get creative! Add your unique design, choose your colors, and make any other custom adjustments to create something truly one-of-a-kind.</p>
            </div>
        </div>
        <!-- fabric -->
        <div class="flex flex-col gap-y-4">
            <h3 class="text-lg font-bold">Canvas</h3>
            <div class="flex gap-x-6 items-start">
                <div class="w-full flex gap-x-4">
                    <div class="flex flex-col justify-between">
                        <div class="flex flex-col gap-y-2">
                            <div id="canvasText" class="flex w-10 h-10 border border-black rounded-md cursor-pointer justify-center items-center text-center">@include('svgs.text')</div>
                            <div id="canvasImg" class="flex w-10 h-10 border border-black rounded-md cursor-pointer justify-center items-center text-center">@include('svgs.img')</div>
                            <div id="canvasDraw" class="flex w-10 h-10 border border-black rounded-md cursor-pointer justify-center items-center text-center">
                                <!-- You'll need to create an SVG for drawing or use an existing one -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                    <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                                    <path d="M2 2l7.586 7.586"></path>
                                    <circle cx="11" cy="11" r="2"></circle>
                                </svg>
                            </div>
                        </div>

                        <div id="deleteObject" class="flex w-10 h-10 border border-black rounded-md cursor-pointer justify-center items-center text-center">@include('svgs.delete-custom')</div>
                        <!-- <div>
                            <div id="shirtToggle" class="flex w-10 h-10 border border-black rounded-md cursor-pointer justify-center items-center text-center">@include('svgs.shirt-2')</div>
                        </div> -->
                    </div>
                    <input type="file" id="canvasImgUpload" class="hidden" accept="image/*"/>
                    <canvas id="fabricCanvas" width="1000" height="500" class="border border-black rounded-md"></canvas>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col gap-y-10 font-inter animate-fade-in">
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Description</h3>
                <div class="flex flex-col gap-y-2" x-data="{ charCount: 0, maxChars: 500 }">
                    <textarea name="description" id="description" rows="3" class="w-full border border-black px-4 py-[18px] rounded-lg" placeholder="Please provide your design customization details..." x-on:input="charCount = $event.target.value.length"></textarea>
                    <div class="flex justify-end">
                        <h5 class="text-sm"><span x-text="charCount"></span>/<span x-text="maxChars"></span></h5>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Media</h3>
                <label class="flex flex-col gap-y-6 px-5 py-11 border border-black border-dashed rounded-lg items-center justify-center">
                    <input type="file" name="media[]" id="media" multiple class="hidden">
                    <button type="button" class="bg-cPrimary text-white px-4 py-2 rounded-md" id="uploadButton">Upload Images</button>
                    <div class="flex gap-2 mt-4" id="previewContainer">
                    </div>
                    <h5 class="text-base">Upload your design images (JPEG, PNG). Maximum file size: 100MB each.</h5>
                </label>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Order Type</h3>
                <fieldset class="flex flex-col gap-y-2">
                    <label class="flex items-center gap-x-2">
                        <input id="bulk" type="radio" name="order_type" value="bulk" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary " />
                        Bulk Order (Min. of 10 pcs.)
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="single" type="radio" name="order_type" value="single" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary " />
                        Single Order
                    </label>
                </fieldset>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Customization</h3>
                <fieldset class="flex flex-col gap-y-2">
                    <label class="flex items-center gap-x-2">
                        <input id="standard" type="radio" name="custom_type" value="standard" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary " />
                        Standard Customization
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="personalized" type="radio" name="custom_type" value="personalized" class="border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bbg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary focus:bg-cPrimary" />
                        Personalized Customization
                    </label>
                </fieldset>
            </div>
        </div>

        <div class="flex justify-start gap-x-3">
            <a href="{{ route('customer.place-order.select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]) }}"
                class="flex bg-[#9CA3AF] bg-opacity-20 text-opacity-50 rounded-xl text-black gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-gray-600">
                Back
            </a>
            <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                Continue
            </button>
        </div>
    </form>
    @include('layout.footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/fabric@latest/dist/index.min.js"></script>
<script>
    window.apparelType = '{{ $apparel }}';
    window.guideImageURL = '';
    if (parseInt(window.apparelType) === 1) {
        window.guideImageURL = '{{ asset("imgs/apparelGuides/jersey.jpg") }}';
    }
</script>
</html>