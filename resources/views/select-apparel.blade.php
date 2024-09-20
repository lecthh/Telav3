<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="font-inter bg-white">
    <!-- Navbar Component -->
    @livewire('navigation-bar')

    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <!-- Step Indicator -->

        <div class="container text-start flex flex-col w-35">
            <div class="flex justify-start mb-8 mt-10">
                <div class="flex space-x-2">
                    <div class="w-16 h-16 flex items-center justify-center bg-cGreen text-black rounded-full">1</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-gray-300 text-black rounded-full">2</div>
                    <div class="w-16 h-16 flex items-center justify-center bg-gray-300 text-black rounded-full">3</div>
                </div>
            </div>
            <div class="text-black mb-6">
                <h2 class="text-2xl font-bold">Choose an Apparel</h2>
                <p class="mt-2">Start by picking your favorite type and style of apparel. Whether it's a t-shirt, hoodie, or jersey, we've got plenty of options to suit your needs!</p>
            </div>
        </div>


        <!-- Apparel Options -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 justify-center items-center">
            <!-- Jersey Option -->
            <div class="border-2 border-purple-500 p-4 rounded-lg text-center hover:shadow-lg transition">
                <img src="jersey.png" alt="Jersey" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Jersey</p>
            </div>

            <!-- Polo Shirt Option -->
            <div class="border p-4 rounded-lg text-center hover:shadow-lg transition">
                <img src="polo-shirt.png" alt="Polo Shirt" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Polo Shirt</p>
            </div>

            <!-- T-Shirt Option -->
            <div class="border p-4 rounded-lg text-center hover:shadow-lg transition">
                <img src="tshirt.png" alt="T-Shirt" class="mx-auto mb-4">
                <p class="text-lg font-semibold">T-Shirt</p>
            </div>

            <!-- Hoodie Option -->
            <div class="border p-4 rounded-lg text-center hover:shadow-lg transition">
                <img src="hoodie.png" alt="Hoodie" class="mx-auto mb-4">
                <p class="text-lg font-semibold">Hoodie</p>
            </div>
        </div>

        <!-- Continue Button -->
        <div class="text-center mt-8">
            <button class="bg-purple-500 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition">Continue</button>
        </div>
    </div>

</body>

</html>