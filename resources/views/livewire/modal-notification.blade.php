@php
    $lastDate = null;
@endphp

<div class="flex flex-col gap-y-4 w-full p-4 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center border-b pb-3">
        <div class="flex items-center gap-x-2">
            <h3 class="font-gilroy text-xl font-bold">Notifications</h3>
            @if($notifications->count() > 0)
                <span class="bg-cPrimary text-white text-xs rounded-full px-2 py-0.5">
                    {{ $notifications->count() }}
                </span>
            @endif
        </div>
        <button wire:click="markAllAsRead" class="text-gray-500 hover:text-cPrimary transition-colors p-1 rounded-full hover:bg-gray-100">
            <span class="sr-only">Clear all notifications</span>
            @include('svgs.delete')
        </button>
    </div>
    
    <div class="relative flex justify-center bg-gray-100 rounded-lg p-1 shadow-inner">
        <label class="flex rounded-md cursor-pointer w-full py-1.5 justify-center transition-all duration-200 {{ $filter === 'all' ? 'bg-white text-cPrimary shadow' : 'text-gray-600 hover:bg-gray-200' }}">
            <input type="radio" wire:click="setFilter('all')" name="notif-type" value="all" class="sr-only" {{ $filter === 'all' ? 'checked' : '' }} />
            <span class="flex items-center gap-x-1 text-xs font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                All
            </span>
        </label>
        <label class="flex rounded-md cursor-pointer w-full py-1.5 justify-center transition-all duration-200 {{ $filter === 'unread' ? 'bg-white text-cPrimary shadow' : 'text-gray-600 hover:bg-gray-200' }}">
            <input type="radio" wire:click="setFilter('unread')" name="notif-type" value="unread" class="sr-only" {{ $filter === 'unread' ? 'checked' : '' }} />
            <span class="flex items-center gap-x-1 text-xs font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Unread
            </span>
        </label>
    </div>

    <div class="flex flex-col gap-y-1 overflow-y-auto max-h-[350px] pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        @if ($notifications->isEmpty())
            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <p class="text-center text-gray-500">No notifications available.</p>
                <p class="text-sm text-gray-400">Check back later for updates.</p>
            </div>
        @else
            @foreach ($notifications as $notification)
                @php
                    $currentDate = $notification->created_at->format('F j, Y');
                    $isUnread = !$notification->is_read;
                    // Get the primary key value regardless of name
                    $notificationId = $notification->getKey();
                @endphp

                <!-- Group notifications by date -->
                @if($currentDate != $lastDate)
                    <h3 class="font-inter font-bold text-xs text-gray-500 uppercase tracking-wider pt-3 pb-1 px-2 sticky top-0 bg-white z-10 border-b">
                        {{ $currentDate }}
                    </h3>
                    @php
                        $lastDate = $currentDate; // Update last date
                    @endphp
                @endif

                <div class="flex flex-col rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-150 {{ $isUnread ? 'bg-blue-50 border-l-4 border-cPrimary' : '' }}"
                     wire:click="markAsRead('{{ $notificationId }}')">
                    <div class="flex gap-x-3 p-3">
                        <div class="flex w-10 h-10 justify-center items-center rounded-full p-2 shrink-0 {{ $isUnread ? 'bg-cPrimary bg-opacity-10 text-cPrimary' : 'bg-gray-100 text-gray-500' }}">
                            @include('svgs.order-stage.order-received-icon')
                        </div>
                        <div class="flex flex-col gap-y-1 flex-1">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-start gap-x-2">
                                    <h3 class="font-gilroy font-bold text-sm capitalize {{ $isUnread ? 'text-cPrimary' : 'text-gray-800' }}">
                                        {{ $notification->message }}
                                        @if($isUnread)
                                            <span class="inline-block w-2 h-2 bg-cPrimary rounded-full ml-1 animate-pulse"></span>
                                        @endif
                                    </h3>
                                    <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @if($notification->order_id)
                                    <h5 class="font-inter text-xs text-gray-600">
                                        <a href="{{ route('customer.profile.orders') }}" class="text-cPrimary hover:underline flex items-center gap-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Order #{{ $notification->order_id }}
                                        </a>
                                    </h5>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex gap-x-2 text-xs items-center text-gray-400">
                                    <span>{{ $notification->created_at->format('g:i A') }}</span>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-xs text-gray-400 hover:text-cPrimary">
                                        @if($isUnread)
                                            Mark as read
                                        @else
                                            Remove
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($notifications->count() > 0)
                <div class="text-center py-3 border-t mt-2">
                    <button wire:click="markAllAsRead" class="text-xs font-medium text-cPrimary hover:text-cPrimary hover:underline transition-colors flex items-center justify-center gap-x-1 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Mark all as read
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>