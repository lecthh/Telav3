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
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Review Your Order</h1>
                <p class="font-inter text-base">Before adding your item to the cart, take a moment to review your order to ensure everything is just the way you want it.</p>
            </div>
        </div>
        <div class="flex flex-col gap-y-10 font-inter">
            <div class="flex flex-col gap-y-3">
                <div class="flex flex-col gap-y-3">
                    <h3 class="font-bold">Production Company</h3>
                    <div class="flex gap-x-4 p-4 bg-cGrey rounded-md">
                        <div class="w-[168px] h-[100px] rounded-md bg-cPrimary"></div>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex flex-col gap-y-1">
                                <h4 class="font-gilroy font-bold text-base">EchoPoint Productions</h4>
                                <h3 class="font-gilroy font-bold text-2xl">4696 PHP</h3>
                            </div>
                            <a href="" class="font-inter text-base text-cPrimary hover:underline">View Sample</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-cPrimary">

            <div class="flex flex-col gap-y-3 text-lg">
                <div class="flex justify-between">
                    <h3>Apparel Selected:</h3>
                    <h3 class="font-bold">Jersey</h3>
                </div>
                <div class="flex justify-between">
                    <h3>Production Type</h3>
                    <h3 class="font-bold">Sublimation</h3>
                </div>
                <div class="flex justify-between">
                    <h3>Order Type:</h3>
                    <h3 class="font-bold">Bulk Order</h3>
                </div>
                <div class="flex justify-between">
                    <h3>Customization:</h3>
                    <h3 class="font-bold">Personalized</h3>
                </div>
            </div>

            <hr class="border-cPrimary">
            <div class="flex gap-x-10">
                <div class="flex border w-[168px] h-[132px] rounded-md border-cPrimary bg-cAccent"></div>
                <div class="flex border w-[168px] h-[132px] rounded-md border-cPrimary bg-cAccent"></div>
            </div>
            <div class="flex flex-col gap-y-3">
                <h3 class="text-lg font-bold">Description</h3>
                <h5 class="text-base">Please provide your design customization details, including preferred colors, patterns, artwork, logos, text, and any specific instructions for placement or modifications to the apparel...</h5>
            </div>
            <div class="flex justify-start gap-x-3">
                @livewire('button', ['style' => 'greyed', 'text' => 'Back'])
                @livewire('button', ['text' => 'Add Item to Cart'])
            </div>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>