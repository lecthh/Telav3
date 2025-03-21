<body class="bg-gray-50 flex flex-col min-h-screen">

    <div class="flex flex-grow">
        @include('layout.superAdmin')
        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => $customerModel,
            'columns' => [
            ['field' => 'name', 'label' => 'Name'],
            ['field' => 'email', 'label' => 'Email'],
            ],
            'actions' => [
            ['label' => 'Edit', 'method' => 'editUser'],
            ['label' => 'Delete', 'method' => 'deleteUser'],
            ],
            'primaryKey' => 'user_id',
            'constantFilter' => ['role_type_id' => 1]
            ])
        </main>
    </div>
    @include('layout.footer')
</body>