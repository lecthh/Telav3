<html>

<body class="bg-gray-50 flex flex-col h-full min-h-screen">
    <div class="flex flex-grow">
        @include('layout.superAdmin')

        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => \App\Models\Designer::class,
            'columns' => [
            ['field' => 'user_name', 'label' => 'Designer Name'],
            ['field' => 'production_company_name', 'label' => 'Production Company'],
            ['field' => 'average_rating', 'label' => 'Average Rating'],
            ['field' => 'talent_fee', 'label' => 'Talent Fee'],
            ],
            'primaryKey' => 'designer_id',
            'constantFilterNot' => ['is_verified' => false],
            'sortableRelations' => [],
            'searchableRelations' => [],
            'perPage' => 10,
            'onRowClick' => 'showDesignerDetails',
            'onEdit' => 'editDesigner',
            'nameColumn' => 'user_name',
            'onApprove' => 'approveEntity',
            'bulkAction' => 'delete',
            'type' => 'manage',
            'entityName' => 'Designer',
            ])
        </main>
    </div>
    @livewire('designer-edit-modal')
    @livewire('approve-modal')
    @livewire('order-details-modal')
    @livewire('designer-details-modal')
    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>