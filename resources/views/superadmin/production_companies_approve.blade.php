<html>

<body class="bg-gray-50 flex flex-col h-full min-h-screen">
    <div class="flex flex-grow">
        @include('layout.superAdmin')

        <main class="flex-grow bg-gray-50 p-8 lg:p-12">
            @livewire('base-table', [
            'model' => \App\Models\ProductionCompany::class,
            'columns' => [
            ['field' => 'company_name', 'label' => 'Company Name'],
            ['field' => 'email', 'label' => 'Email'],
            ['field' => 'phone', 'label' => 'Phone'],
            ['field' => 'address', 'label' => 'Address'],
            ],
            'primaryKey' => 'id',
            'sortableRelations' => [],
            'searchableRelations' => [],
            'constantFilterNot' => ['is_verified' => true, ],
            'perPage' => 10,
            'onRowClick' => 'showCompanyDetails',
            'onEdit' => 'editCompany',
            'nameColumn' => 'company_name',
            'bulkAction' => 'approve'
            ])
        </main>
    </div>
    @livewire('production-company-edit-modal')
    @livewire('production-company-details-modal')
    @livewire('approve-modal')
    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>