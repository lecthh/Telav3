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

<body class="flex flex-col h-full justify-between">
    <div class="flex flex-col h-full">
        <div class="flex p-1 bg-cPrimary font-gilroy font-bold text-white text-sm justify-center">Production Hub</div>
        <div class="flex h-full">
            @include('layout.printer')
            <div class="flex flex-col gap-y-10 p-14 bg-[#F9F9F9] h-full w-full animate-fade-in">
                <div class="flex flex-col gap-y-1">
                    <h2 class="font-gilroy font-bold text-3xl text-black">Account</h2>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="flex flex-col gap-y-6 p-5 bg-white drop-shadow-md rounded-md border">
                    <div class="flex flex-col gap-y-10">
                        <ul class="flex gap-x-5">
                            <a href="{{ route('partner.printer.profile.basics') }}">
                                <li class="font-inter font-bold text-xl py-3 hover:text-cPrimary hover:border-b hover:border-cPrimary cursor-pointer transition ease-in-out">
                                    Basics
                                </li>
                            </a>
                            <a href="{{ route('partner.printer.profile.pricing') }}">
                                <li class="font-inter font-bold text-xl py-3 text-cPrimary border-b border-cPrimary hover:text-cPrimary hover:border-cPrimary cursor-pointer">
                                    Pricing
                                </li>
                            </a>
                        </ul>
                        <form action="{{ route('partner.printer.profile.pricing.update') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <table class="min-w-full bg-white border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">
                                                <input type="checkbox" id="select-all" class="mr-2">Select All
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Apparel Type</th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Production Type</th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Base Price ($)</th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Bulk Price ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pricingRecords as $record)
                                        <tr class="odd:bg-gray-100 even:bg-white hover:bg-cAccent hover:bg-opacity-10">
                                            <td class="px-5 py-3 border-b border-gray-200">
                                                <input type="checkbox" name="selected_records[]" value="{{ $record->pricing_id }}" class="record-checkbox">
                                            </td>
                                            <td class="px-5 py-3 border-b border-gray-200">{{ $record->apparelType->name }}</td>
                                            <td class="px-5 py-3 border-b border-gray-200">{{ $record->productionType->name }}</td>
                                            <td class="px-5 py-3 border-b border-gray-200">
                                                <input type="text" name="base_price[{{ $record->pricing_id }}]" value="{{ $record->base_price }}"
                                                    class="px-2 py-1 w-24 border rounded">
                                            </td>
                                            <td class="px-5 py-3 border-b border-gray-200">
                                                <input type="text" name="bulk_price[{{ $record->pricing_id }}]" value="{{ $record->bulk_price }}"
                                                    class="px-2 py-1 w-24 border rounded">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-start mt-5">
                                <button type="submit" id="save-button"
                                    class="flex bg-cPrimary rounded-xl text-white text-[18px] gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                                    Save Selected Prices
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer')
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const recordCheckboxes = document.querySelectorAll('.record-checkbox');
        const saveButton = document.getElementById('save-button');
        
        // Function to update save button state
        function updateSaveButtonState() {
            const anySelected = Array.from(recordCheckboxes).some(checkbox => checkbox.checked);
            saveButton.disabled = !anySelected;
            saveButton.innerText = anySelected ? 'Save Selected Prices' : 'Select Items to Save';
        }
        
        // Select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            recordCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateSaveButtonState();
        });
        
        // Individual checkbox change
        recordCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Update "select all" checkbox
                selectAllCheckbox.checked = Array.from(recordCheckboxes).every(cb => cb.checked);
                updateSaveButtonState();
            });
        });
        
        // Initial button state
        updateSaveButtonState();
    });
</script>

</html>