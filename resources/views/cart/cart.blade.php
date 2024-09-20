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
                    <div class="flex flex-row gap-y-8">
                        <div class="flex flex-col gap-y-4 px-5 py-5 border border-gray-300">
                            <div class="flex flex-col gap-y-2 5 p-x-2.5 p-y-2.5">
                                <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <div class="flex flex-row justify-between">
                                <h3>Apparel Selected:</h3>
                                <h3>Jersey</h3>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h3>Production Type:</h3>
                                <h3>Sublimation</h3>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h3>Order Type:</h3>
                                <h3>Bulk</h3>                                
                            </div>
                            <div class="flex flex-row justify-between">
                                <h3>Customization:</h3>
                                <h3>Personalized</h3>                                
                            </div>                                                        
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-1 ml-auto">
                        <h3>4996 PHP</h3>
                        <div class="flex flex-row gap-y-2 5">
                            <h3>remove</h3>
                        </div>
                    </div>                                          
                </div>
                <hr>
            </div>  
            <div class="flex flex-col gap-y-8 p-y-6">
                <div class="flex flex-row gap-y-8">
                    <div class="flex flex-col gap-y-4 px-5 py-5 border border-gray-300">
                        <div class="flex flex-col gap-y-2 5 p-x-2.5 p-y-2.5">
                            <img src="{{ asset('images/shirt.png') }}" alt="Example Image" class="w-full h-auto">
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <div class="flex flex-row justify-between">
                            <h3>Apparel Selected:</h3>
                            <h3>Jersey</h3>                                
                        </div>
                        <div class="flex flex-row justify-between">
                            <h3>Production Type:</h3>
                            <h3>Sublimation</h3>                                
                        </div>
                        <div class="flex flex-row justify-between">
                            <h3>Order Type:</h3>
                            <h3>Bulk</h3>                                
                        </div>
                        <div class="flex flex-row justify-between">
                            <h3>Customization:</h3>
                            <h3>Personalized</h3>                                
                        </div>                                                        
                    </div>
                </div>
                <div class="flex flex-col gap-y-1 ml-auto">
                    <h3>4996 PHP</h3>
                    <div class="flex flex-row gap-y-2 5">
                        <h3>remove</h3>
                    </div>
                </div>                                          
            </div>            
        </div>  
    </div>
</body>


</html>