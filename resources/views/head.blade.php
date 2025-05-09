<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>{{ $title ?? 'Tel-A Printhub' }}</title>
    @vite('resources/css/app.css')
    <script>
        window.appConfig = {
            PUSHER_APP_KEY: "{{ config('javascript.pusher_app_key') }}",
            PUSHER_APP_CLUSTER: "{{ config('javascript.pusher_app_cluster') }}"
        };
    </script>
    @livewireStyles
</head>