<body class="bg-gray-50 flex flex-col min-h-screen">

    <div class="flex flex-grow">
        @include('layout.superAdmin')
        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => \App\Models\User::class,
            'columns' => [
            ['field' => 'name', 'label' => 'Name'],
            ['field' => 'email', 'label' => 'Email'],
            ['field' => 'role_name', 'label' => 'Role'],
            ],
            'actions' => [
            ['label' => 'Edit', 'method' => 'editUser'],
            ['label' => 'Delete', 'method' => 'deleteUser'],
            ],
            'primaryKey' => 'user_id',
            'constantFilterNot' => ['role_type_id' => 4],
            'sortableRelations' => [
            'role_name' => [
            'table' => 'role_types',
            'first' => 'users.role_type_id',
            'second' => 'role_types.id',
            'column' => 'role_types.role_name'
            ]
            ],
            'searchableRelations' => [
            'roleType' => [
            'relation' => 'roleType',
            'column' => 'role_name'
            ]
            ],
            'perPage' => 10
            ])
        </main>
    </div>
    @include('layout.footer')
</body>