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
    @livewire('navigation-bar')
    <div class="flex flex-row gap-y-2.5">
        <!-- LEFT HALF -->
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-[900px] h-[942]">

            <div class="flex flex-col gap-y-5">
                <div class="flex flex-col gap-y-3 w-[447px]">
                    <h1 class="font-gilroy font-bold text-5xl">Checkout</h1>
                    <h3 class="font-inter text-base">Before adding your item to the cart, take a moment to review your order to ensure everything is just the way you want it.</h3>
                </div>
            </div>

            <div class="flex flex-row gap-y-2.5">
                <div class="flex flex-col gap-y-10 flex-grow">
                    <div class="flex flex-col gap-y-6">
                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">Email</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg">
                                    <h3 class="font-inter text-base">janeemail@gmail.com</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-y-6">
                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">Country/Region</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 px-5 py-4 border border-black rounded-lg">
                                    <select class="font-inter text-base border-none focus:ring-0 outline-none">
                                        <option value="philippines">Philippines</option>
                                        <option value="usa">USA</option>
                                        <option value="canada">Canada</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>                            
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <h2 class="font-inter font-bold text-lg">Address</h2>
                            <div class="flex flex-col gap-y-2">
                                <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg">
                                    <h3 class="font-inter text-base">1258, University Belt</h3>
                                </div>
                            </div>                            
                        </div>   
                        <div class="flex flex-row gap-x-6 justify-between">
                            <div class="flex flex-col gap-y-4">
                                <h2 class="font-inter font-bold text-lg">State/Province</h2>
                                <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 px-5 py-4 border border-black rounded-lg w-[184px]">
                                    <select class="font-inter text-base border-none focus:ring-0 outline-none">
                                        <option value="cebu">Cebu</option>
                                        <option value="manila">Manila</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                </div>
                            </div>                            
                            <div class="flex flex-col gap-y-4">
                                <h2 class="font-inter font-bold text-lg">City</h2>
                                <div class="flex flex-col gap-y-2">
                                <div class="flex flex-col gap-y-2.5 px-5 py-4 border border-black rounded-lg w-[184px] ">
                                    <select class="font-inter text-base border-none focus:ring-0 outline-none">
                                        <option value="cebucity">Cebu City</option>
                                        <option value="talisaycity">Talisay City</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-y-4">
                                <h2 class="font-inter font-bold text-lg">Zip Code</h2>
                                <div class="flex flex-col gap-y-2">
                                    <div class="flex flex-row gap-y-2.5 px-5 py-4 border border-black rounded-lg w-[184px]">
                                        <h3 class="font-inter text-base">6045</h3>
                                    </div>
                                </div>
                            </div>                            
                        </div>                     
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-x-3 h-[50px]">
                <div class="flex flex-col gap-y-2.5 px-6 py-3.5 rounded-lg bg-[rgba(156,163,175,0.21)]">
                    <h2 class="font-inter text-lg text-[rgba(0,0,0,0.5)]">Cancel</h2>
                </div>
                <div class="flex flex-col gap-y-2.5">
                    @livewire('button', ['text' => 'Checkout'])
                </div>
            </div>
        </div>

        <!-- RIGHT HALF -->
        <div class="flex flex-col px-[30px] py-[100px] flex-grow bg-[rgba(214,159,251,0.1)]">
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-gilroy font-bold text-2xl">EchoPoint Productions</h1>
                    <a href="">@include('svgs.chevron')</a>                    
                </div>
                <hr>
            </div>
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-col gap-y-8 py-6">
                    <div class="flex flex-row gap-x-3 items-center">
                        <div class="flex flex-col gap-y-4 px-6 py-6 border border-black rounded-lg bg-[#F3F3F3]">
                            <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">                              
                        </div>
                        <div class="flex flex-col gap-y-2 flex-grow">
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Apparel Selected:</h2>
                                <h2 class="font-inter font-bold text-lg">Jersey</h2>                                
                            </div>  
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Production Type:</h2>
                                <h2 class="font-inter font-bold text-lg">Sublimation</h2>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Order Type:</h2>
                                <h2 class="font-inter font-bold text-lg">Bulk</h2>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Customization:</h2>
                                <h2 class="font-inter font-bold text-lg">Personalized</h2>                                
                            </div>                                
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 ml-auto items-end">
                        <h2 class="font-gilroy font-bold text-2xl text-cPrimary">4996 PHP</h2>
                        <div class="flex flex-row gap-y-2.5">
                            <h2 class="font-gilroy font-bold text-base text-cAccent">remove</h2>
                        </div>                        
                    </div>
                </div>
                <hr>
                <div class="flex flex-col gap-y-8 py-6">
                    <div class="flex flex-row gap-x-3 items-center">
                        <div class="flex flex-col gap-y-4 px-6 py-6 border border-black rounded-lg bg-[#F3F3F3]">
                            <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">                              
                        </div>
                        <div class="flex flex-col gap-y-2 flex-grow">
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Apparel Selected:</h2>
                                <h2 class="font-inter font-bold text-lg">Jersey</h2>                                
                            </div>  
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Production Type:</h2>
                                <h2 class="font-inter font-bold text-lg">Sublimation</h2>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Order Type:</h2>
                                <h2 class="font-inter font-bold text-lg">Bulk</h2>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h2 class="font-inter text-lg">Customization:</h2>
                                <h2 class="font-inter font-bold text-lg">Personalized</h2>                                
                            </div>                                
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 ml-auto items-end">
                        <h2 class="font-gilroy font-bold text-2xl text-cPrimary">4996 PHP</h2>
                        <div class="flex flex-row gap-y-2.5">
                            <h2 class="font-gilroy font-bold text-base text-cAccent">remove</h2>
                        </div>                        
                    </div>
                </div>                
            </div>

            <div class="flex flex-col gap-y-1">
                <div class="flex flex-row justify-between">
                    <h2 class="font-gilroy font-bold text-[30px]">Total</h2>
                    <h2 class="font-gilroy font-bold text-[30px]">10000 PHP</h2>
                </div> 
                <div class="flex flex-col gap-y-2.5">
                    <h3 class="font-inter text-sm text-gray-500">Please note that this payment serves as a down payment to secure the services of the production company and designers. The remaining balance will be due once your order is completed.</h3>
                </div>               
            </div>
         </div>

    </div>

</body>


</html>


