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
    <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px]">
        <div class="flex flex-col gap-y-6">
            <div class="flex flex-col gap-y-3">
                <h1 class="font-gilroy font-bold text-5xl">Cart</h1>
            </div>
        </div>

        <div class="flex flex-col gap-y-[60px]">
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-row gap-y-4 items-center justify-between">
                    <h2 class="font-gilroy font-bold text-2xl">EchoPoint Productions</h1>
                    <a href="">@include('svgs.chevron')</a>
                </div> 
                <hr class ="mt-4">  
            </div>
            
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-col gap-y-8 p-y-6">
                    <div class="flex flex-row gap-x-8 ">
                        <div class="flex flex-col gap-y-4 px-5 py-5 border border-black rounded-lg bg-[#F3F3F3]">
                            <div class="flex flex-col gap-y-2 5 p-x-2.5 p-y-2.5">
                                <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">
                            </div>
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
            </div>  
          
            <div class="flex flex-col gap-y-2">
                <div class="flex flex-col gap-y-8 p-y-6">
                    <div class="flex flex-row gap-x-8 ">
                        <div class="flex flex-col gap-y-4 px-5 py-5 border border-black rounded-lg bg-[#F3F3F3]">
                            <div class="flex flex-col gap-y-2 5 p-x-2.5 p-y-2.5">
                                <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">
                            </div>
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
                        <div class="flex flex-row gap-y-2 5">
                            <h2 class="font-gilroy font-bold text-base text-cAccent">remove</h2>
                        </div>
                    </div>                                          
                </div>
                <hr>
            </div>              

        </div> 
        
        <div class="flex flex-row justify-between">
            <h2 class="font-gilroy font-bold text-[30px]">Total</h2>
            <h2 class="font-gilroy font-bold text-[30px]">10000 PHP</h2>
        </div>

        <div class="flex flex-col gap-y-2.5">
            <div class="flex flex-col gap-y-2.5 py-3.5 items-start">
                @livewire('button', ['text' => 'Checkout'])
            </div>
        </div>

    </div>
</body>


</html>