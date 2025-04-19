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
            ['field' => 'status', 'label' => 'Status '],
            ],
            'primaryKey' => 'user_id',
            'constantFilter' => ['role_type_id' => 1, ],
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
            'onApprove' => 'approveEntity',
            'nameColumn' => 'name',
            'bulkAction' => 'delete',
            'type' => 'manage',
            'entityName' => 'User',
            ])
        </main>
    </div>

    @livewire('user-details-modal')
    @livewire('order-details-modal')
    @livewire('approve-modal')
    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>