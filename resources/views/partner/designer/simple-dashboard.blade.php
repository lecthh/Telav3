<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-screen">
    <div class="flex p-1 bg-cGreen font-bold text-black text-sm justify-center">Designer Hub</div>
    <div class="flex-grow flex">
        @include('layout.designer')
        <div class="p-8 bg-gray-50 w-full">
            <h1 class="text-2xl font-bold mb-4">Hello, {{ $designer->user->name }}</h1>
            <div class="flex gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <h2>Assigned Orders</h2>
                    <p class="text-xl">{{ $assignedOrdersCount }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h2>Completed Orders</h2>
                    <p class="text-xl">{{ $completedOrdersCount }}</p>
                </div>
            </div>
            <a href="{{ route('partner.designer.orders') }}" class="bg-blue-500 text-white px-4 py-2 rounded">View Orders</a>
        </div>
    </div>
</body>
</html>