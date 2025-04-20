<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css " rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-full justify-between bg-gray-50">
    <div class="flex flex-col h-full">
        <x-blocked-banner-wrapper :entity="$productionCompany" />
        <div class="flex p-1.5 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">
            Production Hub
        </div>
        <div class="flex h-full">
            @include('layout.printer')

            <div class="flex flex-col gap-y-6 p-8 bg-[#F9F9F9] h-full w-full animate-fade-in">
                <div class="flex justify-between items-center">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Company Profile</h2>
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-200">
                        <ul class="flex gap-x-5 px-6">
                            <a href="{{ route('partner.printer.profile.basics') }}">
                                <li class="font-inter font-semibold text-base py-4 text-gray-600 hover:text-cPrimary hover:border-b-2 hover:border-cPrimary cursor-pointer transition duration-150">
                                    Company Information
                                </li>
                            </a>
                            <a href="{{ route('partner.printer.profile.pricing') }}">
                                <li class="font-inter font-semibold text-base py-4 border-b-2 text-cPrimary border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer transition duration-150">
                                    Pricing
                                </li>
                            </a>
                        </ul>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('partner.printer.profile.pricing.update') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Set prices for each apparel type and production method combination. Use the checkboxes to select multiple items for bulk updating.</p>
                                <div class="flex gap-2">
                                    <button id="selectAll" type="button" class="text-sm text-cPrimary hover:underline">Select All</button>
                                    <span class="text-gray-300">|</span>
                                    <button id="deselectAll" type="button" class="text-sm text-cPrimary hover:underline">Deselect All</button>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input type="checkbox" id="header-checkbox" class="rounded text-cPrimary focus:ring-cPrimary">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Apparel Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Production Method
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Base Price (PHP)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Bulk Price (PHP)
                                                <span class="text-xs normal-case font-normal text-gray-400">(Min. 10 items)</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($pricingRecords as $record)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="selected_records[]" value="{{ $record->pricing_id }}" class="record-checkbox rounded text-cPrimary focus:ring-cPrimary">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $record->apparelType->name ?? 'Unknown' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $record->productionType->name ?? 'Unknown' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                                    </div>
                                                    <input type="number"
                                                        name="base_price[{{ $record->pricing_id }}]"
                                                        value="{{ old('base_price.' . $record->pricing_id, $record->base_price) }}"
                                                        step="0.01"
                                                        min="0"
                                                        class="pl-7 block w-32 sm:text-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary">
                                                </div>
                                                @error('base_price.' . $record->pricing_id)
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                                    </div>
                                                    <input type="number"
                                                        name="bulk_price[{{ $record->pricing_id }}]"
                                                        value="{{ old('bulk_price.' . $record->pricing_id, $record->bulk_price) }}"
                                                        step="0.01"
                                                        min="0"
                                                        class="pl-7 block w-32 sm:text-sm border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary">
                                                </div>
                                                @error('bulk_price.' . $record->pricing_id)
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-end">
                                <button
                                    type="submit"
                                    class="flex bg-cPrimary rounded-md text-white font-medium text-base px-6 py-3 justify-center transition duration-150 ease-in-out hover:bg-purple-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                    Update Pricing
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerCheckbox = document.getElementById('header-checkbox');
            const recordCheckboxes = document.querySelectorAll('.record-checkbox');
            const selectAllBtn = document.getElementById('selectAll');
            const deselectAllBtn = document.getElementById('deselectAll');

            headerCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                recordCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });

            function updateHeaderCheckbox() {
                const checkedCount = document.querySelectorAll('.record-checkbox:checked').length;
                headerCheckbox.checked = checkedCount === recordCheckboxes.length;
                headerCheckbox.indeterminate = checkedCount > 0 && checkedCount < recordCheckboxes.length;
            }

            recordCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateHeaderCheckbox);
            });

            selectAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                recordCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateHeaderCheckbox();
            });

            deselectAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                recordCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateHeaderCheckbox();
            });
        });
    </script>
</body>

</html>