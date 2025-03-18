<div class="flex flex-col border-r border-black border-opacity-20 h-full w-[280px]">
    <div class="flex gap-x-2 p-3 border-b border-black border-opacity-20">
        <div class="flex p-1 bg-black bg-opacity-10 rounded-sm">
            @include('svgs.home')
        </div>
        <h4 class="font-gilroy font-bold text-base text-black">{{ $productionCompany->company_name }}</h4>
    </div>
    <ul class="flex flex-col gap-y-2 px-3 py-2">
        <a href="{{ route('designer-dashboard') }}">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.dashboard')
                <h3>Dashboard</h3>
            </li>
        </a>
        <a href="">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.bell')
                <h3>Notifications</h3>
            </li>
        </a>
        <a href="{{ route('partner.designer.orders') }}">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.shelf-drawer')
                <h3>Orders</h3>
            </li>
        </a>
        <a href="">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.chat-bubble-smiley')
                <h3>Reviews</h3>
            </li>
        </a>
        <a href="">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.cog')
                <h3>Account</h3>
            </li>
        </a>
        <a href="{{ route('logout') }}">
            <li class="flex gap-x-2 p-1 rounded-sm text-black hover:bg-cGreen hover:bg-opacity-20 cursor-pointer items-center">
                @include('svgs.logout')
                <h3>Logout</h3>
            </li>
        </a>
    </ul>
</div>