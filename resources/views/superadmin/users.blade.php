<html>

<body class="bg-gray-50 flex flex-col h-full min-h-screen">
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
            'primaryKey' => 'user_id',
            'constantFilterNot' => ['role_type_id' => 4, ],
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
            'perPage' => 10,
            'onRowClick' => 'showUserDetails',
            'onEdit' => 'editUser',
            'nameColumn' => 'name',
            'bulkAction' => 'delete'
            ])
        </main>
    </div>

    @livewire('user-details-modal')
    @livewire('edit-user-details-modal')
    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>