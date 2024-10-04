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

<body class="h-full">
    @include('layout.nav')
    <div class="flex flex-row animate-fade-in h-screen">
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] w-[1200px] justify-start h-full">
            <div class="flex flex-col gap-y-5">
                <div class="flex flex-col gap-y-3">
                    <h1 class="font-gilroy font-bold text-5xl">Profile Page</h1>
                </div>
                <div class="flex mb-4 gap-x-[20px]">
                    <a href="{{ route('customer.profile.basics') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary ">Basics</a>
                    <a href="{{ route('customer.profile.orders') }}" class="font-inter text-[24px] font-bold text-cPrimary underline underline-offset-8 transition-colors duration-200 hover:text-purple-700">Order</a>
                    <a href="{{ route('customer.profile.reviews') }}" class="font-inter text-[24px] font-bold text-black transition-colors duration-200 hover:underline underline-offset-8 hover:text-cPrimary">Reviews</a>
                </div>
            </div>

            <div class="flex flex-col h-full">
                <div class="flex flex-col gap-x-[18px] h-full">
                    @foreach($orders as $order)
                    <button class="flex flex-col gap-y-2 flex-grow order-button" 
                            data-order-id="{{ $order->order_id }}" 
                            data-order-status="{{ $order->status->name }}" 
                            data-order-created-at="{{ $order->created_at }}" 
                            data-order-notifications='@json($order->notifications)'>
                        <div class="flex w-full justify-between">
                            <div class="flex flex-col">
                                <h2 class="font-inter font-bold text-lg">Order no.{{ $order->order_id }}</h2>
                            </div>
                            <h2 class="font-inter font-bold text-base text-gray-500">{{ $order->created_at->format('M j, Y')}}</h2>
                        </div>
                        <h2 class="font-inter text-sm text-gray-500">{{ $order->status->name ?? 'in progress' }}</h2>
                        <hr>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="order-details" class="animate-fade-in-left flex flex-col gap-y-10 px-[30px] py-[100px] flex-grow bg-[rgba(214,159,251,0.1)] h-full hidden">
            <div class="flex flex-col gap-y-4">
                <div class="flex flex-col gap-y-4">
                    <h2 class="font-gilroy font-bold text-2xl">Order no. <span id="order-id-display"></span></h2>
                </div>
                <hr>
            </div>

            <div class="flex flex-col gap-y-6 text-base" id="order-status-details"></div>
            <div class="flex flex-col gap-y-6 text-base overflow-y-auto max-h-[300px]" id="order-notifications"></div>
        </div>
    </div>
    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderButtons = document.querySelectorAll('.order-button');
            const orderDetails = document.getElementById('order-details');
            const orderIdDisplay = document.getElementById('order-id-display');
            const orderStatusDetails = document.getElementById('order-status-details');
            const orderNotifications = document.getElementById('order-notifications');

            orderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = button.getAttribute('data-order-id');
                    const orderStatus = button.getAttribute('data-order-status');
                    const orderCreatedAt = new Date(button.getAttribute('data-order-created-at'));
                    const formattedDate = orderCreatedAt.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                    const formattedTime = orderCreatedAt.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                    });

                    orderIdDisplay.textContent = orderId;
                    orderDetails.classList.remove('hidden');
                    orderDetails.classList.add('flex');

                    orderStatusDetails.innerHTML = `
                        <div class="flex flex-row gap-x-7 justify-between">
                            <div class="flex flex-col gap-y-1">
                                <h2 class="font-inter font-bold text-lg">${orderStatus}</h2>
                                <h2 class="font-inter text-base text-gray-500">Order is in Progress</h2>
                            </div>
                            <div class="flex flex-col gap-y-1 items-end">
                                <h2 class="font-inter font-bold text-lg">${formattedDate}</h2>
                                <h2 class="font-inter text-base text-gray-500">${formattedTime}</h2>
                            </div>
                        </div>
                    `;

                    const notifications = JSON.parse(button.getAttribute('data-order-notifications'));
                    let notificationsHTML = '';
                    notifications.forEach(notification => {
                        notificationsHTML += `
                            <div class="flex flex-col gap-y-2">
                                <h2 class="font-inter font-bold text-sm">${notification.id}</h2>
                                <p class="font-inter text-xs text-gray-500">${notification.message}</p>
                                <p class="font-inter text-xs text-gray-400">${new Date(notification.created_at).toLocaleString()}</p>
                            </div>
                        `;
                    });
                    orderNotifications.innerHTML = notificationsHTML || '<p class="font-inter text-gray-500">No notifications for this order.</p>';
                });
            });
        });
    </script>
</body>

</html>
