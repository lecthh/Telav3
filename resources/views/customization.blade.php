<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>Customize Your Apparel</title>
</head>

<body class="font-inter bg-white">
    @include('layout.nav')
    <div class="container mx-auto p-8 items-start">
        <div class="flex gap-5 mb-8 mt-10">
            <div class="w-16 h-16 flex items-center justify-center text-cDarkGrey text-xl font-gilroy font-bold bg-cGrey rounded-full">1</div>
            <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">2</div>
            <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">3</div>
            <div class="w-16 h-16 flex items-center justify-center bg-cGreen bg-opacity-70 text-xl text-black font-gilroy font-bold rounded-full">4</div>
            <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">5</div>
        </div>

        <div class="text-black max-w-xl mb-10">
            <h2 class="text-5xl font-gilroy font-bold">Customize Your Apparel</h2>
            <p class="mt-4 font-medium">
                Now it's time to get creative! Add your unique design, choose your colors, and make any other custom adjustments to create something truly one-of-a-kind.
            </p>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-8">
                <label for="description" class="font-medium mb-2 block">Description</label>
                <textarea id="description" name="description" rows="4" maxlength="140" class="w-full p-3 border border-black rounded-md" placeholder="Please provide your design customization details, including preferred colors, patterns, artwork, logos, text, and any specific instructions for placement or modifications to the apparel..."></textarea>
                <div class="text-right text-sm mt-1">0/140</div>
            </div>

            <div class="mb-8">
                <label class="font-medium mb-2 block">Media</label>
                <div class="border-dashed border-2 border-black p-6 rounded-lg text-center">
                    <label class="block mb-3 text-purple-500 cursor-pointer">Upload from computer</label>
                    <input type="file" name="media" class="hidden">
                    <p class="text-sm text-gray-500">Upload your design image (JPEG, PNG). Maximum file size: 100MB.</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="font-medium mb-2 block">Order Type</label>
                <div class="flex flex-col items-start gap-4">

                    <div>
                        <input type="radio" name="order_type" id="bulk_order" value="Bulk" class="mr-2">
                        <label for="bulk_order" class="cursor-pointer">Bulk Order (Minimum of 10 pcs.)</label>
                    </div>
                    <div>
                        <input type="radio" name="order_type" id="single_order" value="Single" class="mr-2">
                        <label for="single_order" class="cursor-pointer">Single Order</label>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="font-medium mb-2 block">Customization</label>
                <div class="flex flex-col items-start gap-4">
                    <div class="relative">
                        <input type="radio" name="customization" id="standard" value="Standard" class="mr-2">
                        <label for="standard" class="cursor-pointer">Standard</label>
                    </div>
                    <div class="relative">
                        <input type="radio" name="customization" id="personalized" value="Personalized" class="mr-2">
                        <label for="personalized" class="cursor-pointer">Personalized Customization</label>
                        <span class="inline-block ml-2 cursor-help text-gray-500">?</span>
                    </div>
                </div>
            </div>


        </form>
        <div class="flex mt-16 space-x-3 mb-4">
            <form action="{{ route('select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]) }}" method="get">
                @csrf
                <div class="text-left">
                    @livewire('button', ['text' => 'Back', 'style' => 'greyed'])
                </div>
            </form>

            <form id="production-form" action="{{ route('select-production-type-post') }}" method="POST">
                @csrf
                <input type="hidden" name="production_type" id="production_type" value="">

                <div class="text-left">
                    @livewire('button', ['text' => 'Continue'])
                </div>
            </form>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>