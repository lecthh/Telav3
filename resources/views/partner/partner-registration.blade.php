<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen bg-gray-50">
    @include('layout.nav')

    <div class="flex-grow py-16 px-6 md:px-10 lg:px-16">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="mb-12">
                <h1 class="font-gilroy font-bold text-4xl md:text-5xl text-gray-900 mb-4">Become a Partner</h1>
                <p class="font-inter text-lg text-gray-600 max-w-3xl">Join our creative ecosystem and showcase your talents. Whether you're a production company or a freelance designer, we're excited to collaborate with you.</p>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <!-- Role Selection Cards -->
                <div class="mb-10">
                    <h2 class="font-inter font-bold text-xl mb-6 text-gray-800">Choose your role</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Producer Card -->
                        <label for="producer" class="group cursor-pointer">
                            <div class="flex items-start p-6 border-2 rounded-lg transition-all duration-200 producer-card hover:border-cPrimary hover:bg-purple-50">
                                <input type="radio" id="producer" name="role" value="producer" class="mt-1 form-radio border border-gray-300 w-5 h-5 checked:bg-cPrimary checked:hover:bg-cPrimary focus:ring-2 focus:ring-cPrimary" checked>

                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <h3 class="font-gilroy font-bold text-xl text-gray-900">Production Company</h3>
                                        <span class="ml-3 px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Business</span>
                                    </div>
                                    <p class="mt-2 text-gray-600">Register your production company and start receiving orders for custom apparel printing, embroidery, and more.</p>
                                    <ul class="mt-4 space-y-2">
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Manage your production capabilities
                                        </li>
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Set your own pricing structure
                                        </li>
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Collaborate with our network of designers
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </label>

                        <!-- Designer Card -->
                        <label for="designer" class="group cursor-pointer">
                            <div class="flex items-start p-6 border-2 rounded-lg transition-all duration-200 designer-card hover:border-cPrimary hover:bg-purple-50">
                                <input type="radio" id="designer" name="role" value="designer" class="mt-1 form-radio border border-gray-300 w-5 h-5 checked:bg-cPrimary checked:hover:bg-cPrimary focus:ring-2 focus:ring-cPrimary">

                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <h3 class="font-gilroy font-bold text-xl text-gray-900">Designer</h3>
                                        <span class="ml-3 px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">Creative</span>
                                    </div>
                                    <p class="mt-2 text-gray-600">Showcase your design skills and work with production companies to bring customer visions to life.</p>
                                    <ul class="mt-4 space-y-2">
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Work as freelance or with a company
                                        </li>
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Build your portfolio and reputation
                                        </li>
                                        <li class="flex items-center text-sm text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Set your own design fees
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Registration Forms -->
                <div id="registration-forms" class="mt-8">
                    <div id="producer-registration" class="transition-all duration-300">
                        <livewire:producer-registration />
                    </div>

                    <div id="designer-registration" class="hidden transition-all duration-300">
                        <livewire:designer-registration />
                    </div>
                </div>
            </div>

            <!-- Testimonials Section (Optional) -->
            <div class="mt-16">
                <h2 class="font-gilroy font-bold text-2xl text-gray-900 mb-8 text-center">Why Partner With Us?</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                <span class="text-gray-600 font-bold">EP</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Elite Prints Inc.</h3>
                                <p class="text-sm text-gray-600">Production Partner since 2023</p>
                            </div>
                        </div>
                        <p class="text-gray-700">"Partnering with this platform has increased our customer base by 40% in just six months. The streamlined order process makes it easy to manage production efficiently."</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                <span class="text-gray-600 font-bold">AR</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Alex Rivera</h3>
                                <p class="text-sm text-gray-600">Freelance Designer</p>
                            </div>
                        </div>
                        <p class="text-gray-700">"As a designer, I've been able to focus on what I love - creating - while the platform handles client acquisition and payment processing. It's been a game changer for my business."</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                <span class="text-gray-600 font-bold">TC</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">ThreadCraft Studios</h3>
                                <p class="text-sm text-gray-600">Production & Design Partner</p>
                            </div>
                        </div>
                        <p class="text-gray-700">"The collaboration opportunities with other designers and production companies have helped us expand our capabilities and take on more diverse projects than ever before."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const producerRegistration = document.getElementById('producer-registration');
            const designerRegistration = document.getElementById('designer-registration');
            const producerCard = document.querySelector('.producer-card');
            const designerCard = document.querySelector('.designer-card');
            const userTypeRadios = document.querySelectorAll('input[name="role"]');

            function updateCardStyles() {
                if (document.getElementById('producer').checked) {
                    producerCard.classList.add('border-cPrimary', 'bg-purple-50');
                    designerCard.classList.remove('border-cPrimary', 'bg-purple-50');
                } else {
                    designerCard.classList.add('border-cPrimary', 'bg-purple-50');
                    producerCard.classList.remove('border-cPrimary', 'bg-purple-50');
                }
            }

            userTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateCardStyles();

                    if (this.value === 'producer') {
                        producerRegistration.classList.remove('hidden');
                        designerRegistration.classList.add('hidden');
                    } else if (this.value === 'designer') {
                        producerRegistration.classList.add('hidden');
                        designerRegistration.classList.remove('hidden');
                    }
                });
            });

            // Initialize card styles
            updateCardStyles();
        });
    </script>
</body>

</html>