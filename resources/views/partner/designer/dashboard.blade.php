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
<style>
    .menu-item {
        border-radius: 8px;
    }

    .menu-item.selected {
        background-color: rgba(48, 234, 161, 0.2);
    }
</style>

<body>
    <div class="flex flex-row gap-x-2.5 items-center justify-center bg-[#30EAA1]">
        <h1 class="font-gilroy font-bold text-sm">Designer Hub</h1>
    </div>
    <div class="flex flex-row">
        <!-- LEFT HALF -->
        <div class="flex flex-col border border-gray-200 w-[220px] h-[1000px]">
            <div class="flex flex-row gap-x-2 px-3 py-3 items-center">
                <div class="flex flex-col gap-y-2.5 px-2 py-2">
                    <a href="">@include('svgs.dashboard.home')</a>
                </div>
                <h2 class="font-gilroy font-bold text-base">Janutella Dough</h2>
            </div>
            <hr>
            <div id="menu" class="flex flex-col">
                <div id="dashboard" class="flex flex-row gap-x-2 px-3 py-3 items-center menu-item">
                    <div class="flex flex-row gap-x-2 px-1 py-1">
                        <a href="javascript:void(0)">@include('svgs.dashboard.dashboard')</a>
                    </div>
                    <h2 class="font-inter text-base">Dashboard</h2>
                </div>
                <div id="notifications" class="flex flex-row gap-x-2 px-3 py-3 items-center menu-item">
                    <div class="flex flex-row gap-x-2 px-1 py-1">
                        <a href="javascript:void(0)">@include('svgs.dashboard.bell')</a>
                    </div>
                    <h2 class="font-inter text-base">Notifications</h2>
                </div>
                <div id="orders" class="flex flex-row gap-x-2 px-3 py-3 items-center menu-item">
                    <div class="flex flex-row gap-x-2 px-1 py-1">
                        <a href="javascript:void(0)">@include('svgs.dashboard.shelf')</a>
                    </div>
                    <h2 class="font-inter text-base">Orders</h2>
                </div>
                <div id="reviews" class="flex flex-row gap-x-2 px-3 py-3 items-center menu-item">
                    <div class="flex flex-row gap-x-2 px-1 py-1">
                        <a href="javascript:void(0)">@include('svgs.dashboard.chat')</a>
                    </div>
                    <h2 class="font-inter text-base">Reviews</h2>
                </div>
                <div id="account" class="flex flex-row gap-x-2 px-3 py-3 items-center menu-item">
                    <div class="flex flex-row gap-x-2 px-1 py-1">
                        <a href="javascript:void(0)">@include('svgs.dashboard.account')</a>
                    </div>
                    <h2 class="font-inter text-base">Account</h2>
                </div>
            </div>                                                          
        </div>


        <!-- RIGHT HALF -->
        <div id="designer_dashboard" class="flex flex-col gap-y-10 px-[52px] py-[52px]">
            <div class="flex flex-row gap-x-2 px-1 py-1">
                <a href="javascript:void(0)">@include('svgs.dashboard.account')</a>
            </div>
            <h2 class="font-inter text-base">Account</h2>
        </div>

        <div id="designer_notifications" style="display: none;">

        </div>

        <div id="designer_orders" style="display: none;">

        </div>    

        <div id="designer_reviews" style="display: none;">

        </div>

        <div id="designer_account" style="display: none;">

        </div>  
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        });
    </script>    
</body>
</html>