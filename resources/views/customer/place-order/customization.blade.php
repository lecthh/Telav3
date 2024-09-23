<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
@include('layout.nav')

<body class="flex flex-col h-screen justify-between">
    <form method="POST" action="{{ route('customer.place-order.customization-post', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]) }}" enctype="multipart/form-data" class="font-inter bg-white flex flex-col px-[200px] py-[100px] gap-y-[60px]">
        @csrf
        <div class="flex flex-col gap-y-10">
            @include('customer.place-order.steps')
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Customize Your Apparel</h1>
                <p class="font-inter text-base">Now it's time to get creative! Add your unique design, choose your colors, and make any other custom adjustments to create something truly one-of-a-kind.</p>
            </div>
        </div>
        <div class="flex flex-col gap-y-10 font-inter">
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
                        <input id="bulk" type="radio" name="order_type" value="bulk" class="border border-black w-4 h-4 rounded-full" />
                        Bulk Order (Min. of 10 pcs.)
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="single" type="radio" name="order_type" value="single" class="border border-black w-4 h-4 rounded-full" />
                        Single Order
                    </label>
                </fieldset>
            </div>
            <div class="flex flex-col gap-y-4">
                <h3 class="text-lg font-bold">Customization</h3>
                <fieldset class="flex flex-col gap-y-2">
                    <label class="flex items-center gap-x-2">
                        <input id="standard" type="radio" name="custom_type" value="standard" class="border border-black w-4 h-4 rounded-full" />
                        Standard Customization
                    </label>
                    <label class="flex items-center gap-x-2">
                        <input id="personalized" type="radio" name="custom_type" value="personalized" class="border border-black w-4 h-4 rounded-full" />
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
            @livewire('button', ['text' => 'Continue'])
        </div>
    </form>
    @include('layout.footer')
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mediaInput = document.getElementById('media');
        const uploadButton = document.getElementById('uploadButton');
        const previewContainer = document.getElementById('previewContainer');

        uploadButton.addEventListener('click', function() {
            mediaInput.click();
        });

        mediaInput.addEventListener('change', function(event) {
            const files = event.target.files;
            previewContainer.innerHTML = '';

            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-16', 'h-16', 'object-cover', 'rounded-md');
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>

</html>