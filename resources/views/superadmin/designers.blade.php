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
    'onRowClick' => 'showCompanyDetails',
    'onEdit' => 'editCompany',
    'nameColumn' => 'user_name',
    'bulkAction' => 'delete'
])

        </main>
    </div>

    @livewire('delete-confirmation-modal')
    @include('layout.footer')
</body>

</html>