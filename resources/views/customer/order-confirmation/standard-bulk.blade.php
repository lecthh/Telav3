<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col justify-between h-screen">
    <div class="flex flex-col h-full">
        @include('layout.nav')
        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] bg-white">
            <div class="flex flex-col gap-y-3">
                <h3 class="font-gilroy font-bold text-5xl">Order Confirmation</h3>
                <h5 class="font-inter text-base">Order No. {{$order->order_id}}</h5>
            </div>

            <form action="{{ route('confirm-bulk-post') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                <input type="hidden" name="token" value="{{ $order->token }}">

                <div class="flex flex-col gap-y-4 w-[648px]">
                    <h5 class="font-inter font-bold text-lg">Please specify the details for each apparel to be printed.</h5>
                    @if ($errors->any())
                    <div class="text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex gap-x-4">
                        @foreach($sizes as $size)
                        <div class="flex flex-col gap-y-2 text-inter text-base text-start">
                            <h5>{{ $size->name }}</h5>
                            <input type="number" name="sizes[{{ $size->sizes_ID }}]" class="rounded-lg" placeholder="0" value="{{ old('sizes.' . $size->sizes_ID) }}">
                            @error('sizes.' . $size->sizes_ID)
                            <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-start mt-4">
                    <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                        Confirm
                    </button>
                </div>
            </form>


        </div>
    </div>
    @include('layout.footer')
</body>

</html>