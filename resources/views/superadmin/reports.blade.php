<html>

<head>
    <title>Reports</title>
    <!-- Include your CSS/JS assets here -->
</head>

<body class="bg-gray-50 flex flex-col h-full min-h-screen">
    <div class="flex flex-grow">
        @include('layout.superAdmin')
        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('report-table')
        </main>
    </div>

    @livewire('delete-confirmation-modal')
    @livewire('order-details-modal')
    @include('layout.footer')
</body>

</html>