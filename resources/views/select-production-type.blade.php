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

<body class="font-inter bg-white flex flex-col min-h-screen">
    <div class="container mx-auto p-8 items-start flex-grow">
        <div class="container text-start flex flex-col w-35 gap-y-4">
            <div class="flex justify-start mb-8 mt-10">
                <div class="flex gap-5">
                    <div
                        class="w-16 h-16 flex items-center justify-center text-cDarkGrey text-xl font-gilroy font-bold bg-cGrey rounded-full">
                        1</div>
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-cGreen bg-opacity-70 text-xl text-black font-gilroy font-bold rounded-full">
                        2</div>
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">
                        3</div>
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">
                        4</div>
                    <div
                        class="w-16 h-16 flex items-center  justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">
                        5</div>
                </div>
            </div>
            <div class="text-black max-w-xl">
                <h2 class="text-5xl font-gilroy font-bold">Choose Production Type</h2>
                <p class="mt-4 font-inter text-start font-medium mx-auto">
                    Next, decide how you want your design to come to life. You can choose from methods like screen
                    printing or embroidery—whatever best fits your vision!
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 justify-center items-center mt-16" id="production-options">
            <div class="production-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer"
                data-value="Sublimation">
                <img src="{{ asset('imgs/productionType/sublimation.png') }}" alt="Sublimation" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Sublimation</p>
            </div>
            <div class="production-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer"
                data-value="Heat Transfer">
                <img src="{{ asset('imgs/productionType/heat.png') }}" alt="Heat Transfer" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Heat Transfer</p>
            </div>
            <div class="production-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer"
                data-value="Embroidery">
                <img src="{{ asset('imgs/productionType/embroidery.png') }}" alt="Embroidery" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Embroidery</p>
            </div>
        </div>
        <div class="flex mt-16 space-x-3">
            <form action="{{ route('select-apparel') }}" method="get">
                @csrf
                <div class="text-left">
                    @livewire('button', ['text' => 'Back', 'style' => 'greyed'])
                </div>
            </form>

            <form id="production-form" action="{{ route('select-production-type-post') }}" method="POST">
                @csrf
                <input type="hidden" name="production_type" id="production_type" value="">
                <input type="hidden" name="apparel" id="apparel" value="{{ $apparel }}">
                <div class="text-left">
                    @livewire('button', ['text' => 'Continue'])
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productionItems = document.querySelectorAll('.production-item');
            const selectedProductionInput = document.getElementById('production_type');

            productionItems.forEach(item => {
                item.addEventListener('click', function() {
                    productionItems.forEach(i => i.classList.remove('border-purple-500'));
                    productionItems.forEach(i => i.classList.add('border-gray-300'));
                    this.classList.add('border-purple-500');
                    this.classList.remove('border-gray-300');
                    selectedProductionInput.value = this.getAttribute('data-value');
                });
            });
        });
    </script>
    @include('layout.footer')
</body>

</html>