@php
    $lastDate = null;
@endphp

<div class="absolute z-50 top-8 left-[-52px] flex h-[708px] w-[472px] flex-col gap-y-10 rounded-md bg-white px-6 py-7 drop-shadow-md" x-show="isOpen" x-cloak x-data="{ selected: 'all' }">
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

    <!-- Notification list with scroll -->
    <div class="flex flex-col gap-y-8 overflow-y-auto max-h-[500px]">
        @if ($notifications->isEmpty())
            <p>No notifications available.</p>
        @else
            @foreach ($notifications as $notification)
                @php
                    $currentDate = $notification->created_at->format('F j, Y');
                @endphp

                <!-- Group notifications by date -->
                @if($currentDate != $lastDate)
                    <h3 class="font-inter font-bold text-base text-cDarkGrey text-start">{{ $currentDate }}</h3>
                    @php
                        $lastDate = $currentDate; // Update last date
                    @endphp
                @endif

                <!-- Notification content -->
                <div class="flex flex-col gap-y-4 rounded-md hover:bg-cAccent hover:bg-opacity-20 cursor-pointer">
                    <div class="flex gap-x-4 px-2 py-3">
                        <div class="flex w-[52px] h-[52px] justify-center border-2 border-black border-opacity-10 items-center rounded-full p-3">
                            @include('svgs.order-stage.order-received-icon') <!-- Add your icon here -->
                        </div>
                        <div class="flex flex-col gap-y-4">
                            <div class="flex flex-col gap-y-2">
                                <h3 class="font-gilroy font-bold text-base capitalize text-start">{{ $notification->message }}</h3>
                                <h5 class="font-inter text-sm text-start"><span>Order no. {{ $notification->order_id ?? 'Unknown' }}</span></h5>
                            </div>
                            <div class="flex gap-x-3 text-sm items-center justify-start">
                                <h4 class="font-gilroy text-cDarkGrey capitalize">{{ $notification->created_at->format('F j, Y') }}</h4>
                                @include('svgs.dot')
                                <h4 class="font-inter text-cDarkGrey uppercase">{{ $notification->created_at->format('g:i A') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        @endif
    </div>
</div>
