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

<body class="min-h-screen flex flex-col bg-gray-50">
    <x-blocked-banner-wrapper :entity="$designer" />
    <div class="flex p-1.5 bg-cGreen font-gilroy font-bold text-white text-sm justify-center">
        Designer Hub
    </div>

    <div class="flex">
        @include('layout.designer')

        <div class="flex-1 flex flex-col min-h-screen">
            <div class="flex-1 p-6 overflow-auto">
                <div class="max-w-6xl mx-auto">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Notifications</h1>
                        <p class="text-gray-600">View all your system notifications and updates</p>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="font-gilroy font-semibold text-lg text-gray-900">Recent Notifications</h2>

                            @if($notifications->count() > 0)
                            <form action="{{ route('partner.designer.profile.notifications.mark-all-read') }}" method="POST" class="ml-auto">
                                @csrf
                                <button type="submit" class="text-sm text-cGreen hover:underline">Mark all as read</button>
                            </form>
                            @endif
                        </div>

                        @if($notifications->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($notifications as $notification)
                            <div class="p-4 hover:bg-gray-50 flex {{ $notification->is_read ? 'opacity-75' : 'bg-cGreen/5' }}">
                                <div class="flex-shrink-0 mr-4">
                                    @if(Str::contains(strtolower($notification->message), 'review'))
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-cGreen/10 text-cGreen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </span>
                                    @elseif(Str::contains(strtolower($notification->message), 'order') || Str::contains(strtolower($notification->message), 'assigned'))
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    @else
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>

                                    @if($notification->order_id)
                                    <p class="text-xs text-gray-600 mt-1">
                                        Order #{{ substr($notification->order_id, -6) }}

                                        @php
                                        $order = \App\Models\Order::find($notification->order_id);
                                        $route = null;

                                        if ($order && $order->assigned_designer_id == $designer->designer_id) {
                                        if ($order->status_id == 7) {
                                        $route = route('partner.designer.complete-x', $order->order_id);
                                        } else {
                                        $route = route('partner.designer.assigned-x', $order->order_id);
                                        }
                                        }
                                        @endphp

                                        @if($route)
                                        <a href="{{ $route }}" class="text-cGreen hover:underline ml-2">View Order</a>
                                        @endif
                                    </p>
                                    @endif
                                </div>

                                @if(!$notification->is_read)
                                <div class="flex-shrink-0 ml-4 self-center">
                                    <form action="{{ route('partner.designer.profile.notifications.mark-read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-500 hover:text-cGreen">
                                            Mark as read
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                            {{ $notifications->links() }}
                        </div>
                        @else
                        <div class="py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-4 text-xl font-medium text-gray-900">No notifications</h3>
                            <p class="mt-2 text-gray-500">You don't have any notifications at the moment.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer')
</body>

</html>