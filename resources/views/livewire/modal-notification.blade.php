<div class="absolute z-50 flex h-[708px] w-[472px] flex-col gap-y-10 rounded-md bg-white px-6 py-7 drop-shadow-md" x-show="isOpen" x-cloak x-data="{ selected: 'all' }">
    <div class="flex justify-between">
        <h3 class="font-gilroy text-2xl font-bold">Notifications</h3>
        @include('svgs.delete')
    </div>
    <div class="relative flex justify-center bg-cPrimary bg-opacity-20 rounded-md">
        <label :class="{ 'bg-cPrimary text-white': selected === 'all', ' text-white': selected !== 'all' }" class="flex rounded-md cursor-pointer w-full px-6 py-2 justify-center">
            <input type="radio" name="notif-type" value="all" x-model="selected" class="sr-only" />
            All
        </label>
        <label :class="{ 'bg-cPrimary text-white': selected === 'unread', 'text-white': selected !== 'unread' }" class="flex rounded-md cursor-pointer w-full px-6 py-2 justify-center">
            <input type="radio" name="notif-type" value="unread" x-model="selected" class="sr-only" />
            Unread
        </label>
    </div>
    <div class="flex flex-col gap-y-8">
        <div class="flex flex-col gap-y-8">
            <h3 class="font-inter font-bold text-base text-cDarkGrey text-start">Today</h3>
            <div class="flex flex-col gap-y-4 rounded-md hover:bg-cAccent hover:bg-opacity-20 cursor-pointer">
                <div class="flex gap-x-4 px-2 py-3">
                    <div class="flex w-[52px] h-[52px] justify-center border-2 border-black border-opacity-10 items-center rounded-full p-3">@include('svgs.order-stage.order-received-icon')</div>
                    <div class="flex flex-col gap-y-4">
                        <div class="flex flex-col gap-y-2">
                            <h3 class="font-gilroy font-bold text-base capitalize text-start">Order Received</h3>
                            <h5 class="font-inter text-sm text-start"><span>Order no. 8932</span> has been successfully placed and received by the producer</h5>
                        </div>
                        <div class="flex gap-x-3 text-sm items-center justify-start">
                            <h4 class="font-gilroy text-cDarkGrey capitalize">September 4, 2024</h4>
                            @include('svgs.dot')
                            <h4 class="font-inter text-cDarkGrey uppercase">5:09 PM</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>