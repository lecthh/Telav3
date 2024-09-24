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
                    <div class="flex flex-col gap-y-7 flex-grow">


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
                        <livewire:producer-registration />


                        <!-- DESIGNER REGISTRATION VIEW -->
                        <div id="designer-registration" style="display: none;">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const producerRegistration = document.getElementById('producer-registration');
            const designerRegistration = document.getElementById('designer-registration');
            const userTypeRadios = document.querySelectorAll('input[name="role"]');

            userTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
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