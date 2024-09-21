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

<body class="font-inter bg-white flex flex-col min-h-screen">
    @include('layout.nav')

    <div class="container mx-auto p-8 items-start flex-grow">
        <div class="container text-start flex flex-col w-35 gap-y-4">
            <div class="flex justify-start mb-7 mt-10">
                <div class="flex gap-5">
                    <div class="w-16 h-16 flex items-center justify-center text-black text-xl font-gilroy font-bold bg-cGreen rounded-full">1</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">2</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">3</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">4</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-cGrey bg-opacity-70 text-xl text-cDarkGrey font-gilroy font-bold rounded-full">5</div>
                </div>
            </div>
            <div class="text-black max-w-md">
                <h2 class="text-5xl font-gilroy font-bold">Choose an Apparel</h2>
                <p class="mt-4 font-inter text-start font-medium mx-auto">
                    Start by picking your favorite type and style of apparel. Whether it's a t-shirt, hoodie, or jersey, we've got plenty of options to suit your needs!
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 justify-center items-center mt-16" id="apparel-options">
            <div class="apparel-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer" data-value="Jersey">
                <img src="{{ asset('imgs/apparelCategory/jersey.png') }}" alt="Jersey" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Jersey</p>
            </div>
            <div class="apparel-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer" data-value="Polo Shirt">
                <img src="{{ asset('imgs/apparelCategory/poloshirt.png') }}" alt="Polo Shirt" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Polo Shirt</p>
            </div>
            <div class="apparel-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer" data-value="T-Shirt">
                <img src="{{ asset('imgs/apparelCategory/tshirt.png') }}" alt="T-Shirt" class="mx-auto mb-4">
                <p class="text-lg font-semibold">T-Shirt</p>
            </div>
            <div class="apparel-item border-2 bg-[#F3F3F3] border-gray-300 p-4 rounded-lg text-center hover:shadow-lg transition cursor-pointer" data-value="Hoodie">
                <img src="{{ asset('imgs/apparelCategory/hoodie.png') }}" alt="Hoodie" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Hoodie</p>
            </div>
        </div>

        <form id="apparel-form" action="{{ route('select-apparel-post') }}" method="POST">
            @csrf
            <input type="hidden" name="selected_apparel" id="selected_apparel" value="">
            <div class="text-left mt-16">
                @livewire('button', ['text' => 'Continue'])
            </div>
        </form>
    </div>

    @include('layout.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apparelItems = document.querySelectorAll('.apparel-item');
            const selectedApparelInput = document.getElementById('selected_apparel');
            apparelItems.forEach(item => {
                item.addEventListener('click', function() {
                    apparelItems.forEach(i => i.classList.remove('border-purple-500'));
                    apparelItems.forEach(i => i.classList.add('border-gray-300'));
                    this.classList.add('border-purple-500');
                    this.classList.remove('border-gray-300');
                    selectedApparelInput.value = this.getAttribute('data-value');
                });
            });
        });
    </script>

</body>

</html>