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
    @include('layout.nav')
    <div class="flex flex-row gap-x-2.5 flex-grow">
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
            <div class="flex flex-col gap-y-6 items-start">
                <div class="flex flex-col gap-y-3" style="width: 750px;">
                    <h1 class="font-gilroy font-bold text-5xl">Become a Partner</h1>
                    <h2 class="font-inter text-base">Interested in selling your services with us? Whether you're a production company or a freelance designer, we’d love to collaborate and bring your talents to our platform.</h2>
                </div>

                <div class="flex flex-row gap-x-2.5">
                    <div class="flex flex-col gap-y-10 flex-grow">

                        <!-- SELECT ROLE -->
                        <div class="flex flex-col gap-y-6">
                            <div class="flex flex-col gap-y-6">
                                <div class="flex flex-col gap-y-4">
                                    <h2 class="font-inter font-bold text-lg">Choose your role</h2>
                                    <div class="flex flex-row gap-x-8">
                                        <div class="flex flex-row gap-x-2 items-center">
                                            <input type="radio" id="producer" name="role" value="producer" class="form-radio border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary" checked>
                                            <label for="producer" class="font-inter text-base">Producer</label>
                                        </div>
                                        <div class="flex flex-row gap-x-2 items-center">
                                            <input type="radio" id="designer" name="role" value="designer" class="form-radio border border-black w-4 h-4 p-1 py-1 rounded-full checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary">
                                            <label for="designer" class="font-inter text-base">Designer</label>
                                        </div>                                     
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- PRODUCER REGISTRATION VIEW -->
                        <div id="producer-registration">
                            <div class="flex flex-col gap-y-6">
                                <div class="flex flex-col gap-y-4">
                                    <h2 class="font-inter font-bold text-lg">Please select the types of services you offer</h2>
                                    <div class="flex flex-row gap-x-8">
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="sublimation" name="production_type[]" value="sublimation" class="form-checkbox">
                                            <label for="sublimation" class="font-inter text-base">Sublimation</label>
                                        </div>
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="heat-transfer" name="production_type[]" value="heat-transfer" class="form-checkbox">
                                            <label for="heat-transfer" class="font-inter text-base">Heat Transfer</label>
                                        </div>
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="embroidery" name="production_type[]" value="embroidery" class="form-checkbox">
                                            <label for="embroidery" class="font-inter text-base">Embroidery</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="flex flex-col gap-y-6">
                                <div class="flex flex-col gap-y-4">
                                    <h2 class="font-inter font-bold text-lg">Please select the types of apparel you offer</h2>
                                    <div class="flex flex-row gap-x-8">
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="tshirt" name="apparel_type[]" value="tshirt" class="form-checkbox">
                                            <label for="tshirt" class="font-inter text-base">T-Shirt</label>
                                        </div>
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="poloshirt" name="apparel_type[]" value="poloshirt" class="form-checkbox">
                                            <label for="poloshirt" class="font-inter text-base">Polo Shirt</label>
                                        </div>
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="jersey" name="apparel_type[]" value="jersey" class="form-checkbox">
                                            <label for="jersey" class="font-inter text-base">Jersey</label>
                                        </div>
                                        <div class="flex flex-row gap-x-3 items-center">
                                            <input type="checkbox" id="hoodie" name="apparel_type[]" value="hoodie" class="form-checkbox">
                                            <label for="hoodie" class="font-inter text-base">Hoodie</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="flex flex-col gap-y-6 flex-grow">
                                <div class="flex flex-col gap-y-4">
                                    <h2 class="font-inter font-bold text-lg">Company name</h2>
                                    <div class="flex flex-col gap-y-2">
                                        <div class="flex flex-col gap-y-2">
                                            <input type="text" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-row gap-x-6">
                                    <div class="flex flex-col gap-y-4 flex-grow">
                                        <h2 class="font-inter font-bold text-lg">Email address</h2>
                                        <div class="flex flex-col gap-y-2">
                                            <input type="text" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-4 flex-grow">
                                        <h2 class="font-inter font-bold text-lg">Mobile number</h2>
                                        <div class="flex flex-col gap-y-2">
                                            <input type="text" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-y-4">
                                    <h2 class="font-inter font-bold text-lg">Address</h2>
                                    <div class="flex flex-col gap-y-2">
                                        <input type="text" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px]" />
                                    </div>
                                </div>

                                <div class="flex flex-row gap-x-6 flex-grow justify-between">
                                    <div class="flex flex-col gap-y-4 w-full">
                                        <h2 class="font-inter font-bold text-lg">State/Province</h2>
                                        <div class="flex flex-col gap-y-2">
                                            <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full">
                                                <select class="font-inter text-base border-none focus:ring-0 outline-none w-full">
                                                    <option value="" disabled selected>Select State/Province</option>
                                                    <option value="state1">State 1</option>
                                                    <option value="state2">State 2</option>
                                                    <option value="state3">State 3</option>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-4 w-full">
                                        <h2 class="font-inter font-bold text-lg">City</h2>
                                        <div class="flex flex-col gap-y-2">
                                            <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full">
                                                <select class="font-inter text-base border-none focus:ring-0 outline-none w-full">
                                                    <option value="" disabled selected>Select City</option>
                                                    <option value="city1">City 1</option>
                                                    <option value="city2">City 2</option>
                                                    <option value="city3">City 3</option>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-y-4 w-full">
                                        <h2 class="font-inter font-bold text-lg">Zip Code</h2>
                                        <div class="flex flex-col gap-y-2">
                                            <input type="text" class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg h-[50px] w-full" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- DESIGNER REGISTRATION VIEW -->
                        <div id="designer-registration" style="display: none;">
                            

                        </div>








                    </div>
                </div>

                <div class="flex flex-row gap-x-3 items-start py-5">
                    @livewire('button', ['text' => 'Submit'])
                </div>

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const producerRegistration = document.getElementById('producer-registration');
            const designerRegistration = document.getElementById('designer-registration');
            const userTypeRadios = document.querySelectorAll('input[name="role"]');

            userTypeRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'producer') {
                        producerRegistration.style.display = 'block';
                        designerRegistration.style.display = 'none';
                    } else if (this.value === 'designer') {
                        producerRegistration.style.display = 'none';
                        designerRegistration.style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>


</html>