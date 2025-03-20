<body class="bg-gray-50 flex flex-col min-h-screen">

    <div class="flex flex-grow">
        @include('layout.superAdmin')
        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => $customerModel, // Passing the model instead of a query builder
            'columns' => [
            ['field' => 'user_id', 'label' => 'User ID'],
            ['field' => 'name', 'label' => 'Name'],
            ['field' => 'email', 'label' => 'Email'],
            ],
            'actions' => [
            ['label' => 'Edit', 'method' => 'editUser'],
            ['label' => 'Delete', 'method' => 'deleteUser'],
            ],
            'primaryKey' => 'user_id'
            ])


        </main>
    </div>
    @include('layout.footer')
</body>