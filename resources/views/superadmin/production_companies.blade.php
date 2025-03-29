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
            ['field' => 'avg_rating', 'label' => 'Average Rating'],
            ],
            'primaryKey' => 'id',
            'sortableRelations' => [],
            'searchableRelations' => [],
            'perPage' => 10,
            'onRowClick' => 'showCompanyDetails',
            'onEdit' => 'editCompany',
            'nameColumn' => 'company_name',
            ])
        </main>
    </div>

    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>