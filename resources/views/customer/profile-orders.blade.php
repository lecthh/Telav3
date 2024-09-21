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
    <div class="flex flex-row">
<!-- LEFT HALF -->
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-[1200px]">
            <div class="flex flex-col gap-y-5">
                <div class="flex flex-col gap-y-3">
                    <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
                </div>
                <div class="flex flex-row gap-x-5 ">
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl">Basics</h1>
                    </div>
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl text-cPrimary">Orders</h1>
                    </div>
                    <div class="flex flex-row gap-x-[60px] py-3">
                        <h1 class="font-inter font-bold text-2xl">Reviews</h1>
                    </div>                                
                </div>                    
            </div>


            <div class="flex flex-col">
                <div class="flex flex-row gap-x-[18px]">

                    <div class="flex flex-col gap-y-2 flex-grow">

                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <h2 class="font-inter font-bold text-lg">Order no. 3981</h2>
                            </div>
                            <h2 class="font-inter font-bold text-base text-gray-500">September 13, 2024</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">Order Received</h2>
                        <hr>

                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <h2 class="font-inter font-bold text-lg">Order no. 3981</h2>
                            </div>
                            <h2 class="font-inter font-bold text-base text-gray-500">September 13, 2024</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">Order Received</h2>
                        <hr>

                        <div class="flex flex-row justify-between">
                            <div class="flex flex-col">
                                <h2 class="font-inter font-bold text-lg">Order no. 3981</h2>
                            </div>
                            <h2 class="font-inter font-bold text-base text-gray-500">September 13, 2024</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">Order Received</h2>    
                        <hr>                                            
                    </div>
                    
                </div>
            </div>

        </div>

<!-- RIGHT HALF -->
         <div class="flex flex-col gap-y-10 px-[30px] py-[100px] flex-grow bg-[rgba(214,159,251,0.1)]">
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-col gap-y-4">
                    <h2 class="font-gilroy font-bold text-2xl">Order no.3981</h1>
                </div>
                <hr>
            </div>

            <div class="flex flex-col gap-y-6">
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>

                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>
                
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>
                
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>
                
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>
                
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>
                
                <div class="flex flex-row gap-x-7">
                    <!-- ADD ICON THING -->
                     <div class="flex flex-col gap-y-1">
                        <h2 class="font-inter font-bold text-lg">Ready for Collection</h2>
                        <h2 class="font-inter text-base text-gray-500">Order is Complete</h2>
                     </div>
                     <div class="flex flex-col gap-y-1 items-end">
                        <h2 class="font-inter font-bold text-lg">Sep 20</h2>
                        <h2 class="font-inter text-base text-gray-500">12:00 PM</h2>                        
                     </div>
                </div>                
            </div>

         </div>
    </div>
</body>


</html>