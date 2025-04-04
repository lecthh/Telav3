<html>

<body class="bg-gray-50 flex flex-col h-full min-h-screen">
    <div class="flex flex-grow">
        @include('layout.superAdmin')
        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => \App\Models\Order::class,
            'columns' => [
            ['field' => 'order_id', 'label' => 'Order ID'],
            ['field' => 'user.name', 'label' => 'Customer Name'],
            ['field' => 'productionCompany.company_name', 'label' => 'Production Company'],
            ['field' => 'quantity', 'label' => 'Quantity'],
            ['field' => 'final_price', 'label' => 'Final Price'],
            ['field' => 'downpayment_amount', 'label' => 'Downpayment Amount'],
            ['field' => 'status.name', 'label' => 'Status'],

            ],
            'primaryKey' => 'order_id',
            'sortableRelations' => [
            'user_name' => [
            'table' => 'users',
            'first' => 'orders.user_id',
            'second' => 'users.user_id',
            'column' => 'users.name'
            ],
            'production_company_name' => [
            'table' => 'production_companies',
            'first' => 'orders.production_company_id',
            'second' => 'production_companies.id',
            'column' => 'production_companies.company_name'
            ]
            ],
            'searchableRelations' => [
            'user' => [
            'relation' => 'user',
            'column' => 'name'
            ],
            'productionCompany' => [
            'relation' => 'productionCompany',
            'column' => 'company_name'
            ]
            ],
            'perPage' => 10,
            'onRowClick' => 'showOrderDetails',
            'onEdit' => 'editOrder',
            'nameColumn' => 'order_id',
            'bulkAction' => 'delete',
            'type' => 'manage',
            'showActions' => false,
            ])
        </main>
    </div>

    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>