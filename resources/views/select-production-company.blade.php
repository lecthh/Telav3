<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    @vite('resources/css/select.css')
    @vite('resources/css/app.css')
</head>
@include('layout.nav')

<body class="font-inter bg-white">
    <div class="container mx-auto p-8 items-start">
        <div class="container text-start flex flex-col w-35 gap-y-4">
            <div class="flex justify-start mb-8 mt-10">
                <div class="flex gap-5">
                    <div class="w-16 h-16 flex items-center justify-center text-cDarkGrey text-xl font-gilroy font-bold bg-cGrey rounded-full">1</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">2</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGreen bg-opacity-70 text-xl text-black font-gilroy font-bold rounded-full">3</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">4</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">5</div>
                </div>
            </div>
            <div class="text-black max-w-3xl">
                <h2 class="text-5xl font-gilroy font-bold">Choose a Production Company</h2>
                <p class="mt-4 font-inter text-start font-medium mx-auto">
                    Select a trusted production company to bring your custom apparel to life.
                </p>
            </div>
        </div>

        <div class="container flex flex-col w-35 gap-y-4 pt-9">
            <div class="selectDiv mb-2">
                <select class="custom-select">
                    <option selected>Base Price</option>
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </select>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                <!-- Product Card 1 -->
                <div class="border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg hover:shadow-lg transition cursor-pointer w-60 production-item" data-value="Apparel Clothing">
                    <img src="https://via.placeholder.com/150" alt="Product Image" class="w-full mb-4 object-cover">
                    <p class="text-lg font-semibold">Apparel Clothing</p>
                    <p class="text-xl font-bold text-black">4996 PHP</p>
                    <a href="#" class="text-purple-500">Visit Page</a>
                </div>

                <div class="border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg hover:shadow-lg transition cursor-pointer w-60 production-item" data-value="EchoPoint Productions">
                    <img src="https://via.placeholder.com/150" alt="Product Image" class="w-full mb-4 object-cover">
                    <p class="text-lg font-semibold">EchoPoint Productions</p>
                    <p class="text-xl font-bold text-black">4996 PHP</p>
                    <a href="#" class="text-purple-500">Visit Page</a>
                </div>
            </div>
        </div>

        <!-- Form Submission with Selected Production Company -->
        <div class="flex mt-16 space-x-3 mb-4">
            <form action="{{ route('select-production-type', ['apparel' => $apparel, 'productionType' => $productionType]) }}" method="get">
                <input type="hidden" name="apparel" id="apparel" value="{{ $apparel }}">
                <input type="hidden" name="productionType" value="{{ $productionType }}">
                @csrf
                <div class="text-left">
                    @livewire('button', ['text' => 'Back', 'style' => 'greyed'])
                </div>
            </form>

            <form id="production-form" action="{{ route('select-production-company-post') }}" method="POST">
                @csrf
                <input type="hidden" name="production_company" id="production_company" value="">
                <input type="hidden" name="apparel" id="apparel" value="{{ $apparel }}">
                <input type="hidden" name="productionType" value="{{ $productionType }}">
                <div class="text-left">
                    @livewire('button', ['text' => 'Continue'])
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productionItems = document.querySelectorAll('.production-item');
            const selectedProductionCompanyInput = document.getElementById('production_company');

            productionItems.forEach(item => {
                item.addEventListener('click', function() {
                    productionItems.forEach(i => i.classList.remove('border-purple-500'));
                    productionItems.forEach(i => i.classList.add('border-gray-300'));
                    this.classList.add('border-purple-500');
                    this.classList.remove('border-gray-300');
                    selectedProductionCompanyInput.value = this.getAttribute('data-value');
                });
            });
        });
    </script>

    @include('layout.footer')
</body>

</html>