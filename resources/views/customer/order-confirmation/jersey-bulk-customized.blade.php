<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col">
    <div class="flex flex-col flex-grow">
        @include('layout.nav')

        <div class="flex flex-col gap-y-[60px] px-[200px] py-[100px] bg-white">
            <div class="flex flex-col gap-y-3">
                <h3 class="font-gilroy font-bold text-5xl">Order Confirmation</h3>
                <h5 class="font-inter text-base">Order No. {{ $order->order_id }}</h5>
            </div>

            <!-- Start of Form -->
            <form action="{{ route('confirm-jerseybulk-custom-post') }}" method="POST" id="customizationForm">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                <input type="hidden" name="token" value="{{ $order->token }}">

                <div class="flex flex-col gap-y-4 w-[648px]">
                    <h5 class="font-inter font-bold text-lg">Please specify the details for each apparel to be printed.</h5>

                    <table class="table-auto min-w-full overflow-hidden rounded-lg">
                        <thead class="bg-cPrimary text-white border">
                            <tr>
                                <th class="p-3 text-start">No.</th>
                                <th class="p-3 text-start">Name</th>
                                <th class="p-3 text-start">Jersey No.</th>
                                <th class="p-3 text-start">Top Size</th>
                                <th class="p-3 text-start">Short Size</th>
                                <th class="p-3 text-start">W/Pocket</th>
                                <th class="p-3 text-start">Remarks</th>
                                <th class="p-3 text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border" id="rowsTable">
                            @foreach($rows as $index => $row)
                            <tr class="odd:bg-gray-100 even:bg-white">
                                <td class="p-2 font-bold">{{ $index + 1 }}</td>
                                <td class="p-2">
                                    <input type="text" name="rows[{{ $index }}][name]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white" value="{{ old('rows.'.$index.'.name', $row['name']) }}">
                                    <!-- Display validation error for 'name' field -->
                                    @error('rows.'.$index.'.name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                    <input type="text" name="rows[{{ $index }}][jerseyNo]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white" value="{{ old('rows.'.$index.'.jerseyNo', $row['jerseyNo']) }}">
                                    <!-- Display validation error for 'jerseyNo' field -->
                                    @error('rows.'.$index.'.jerseyNo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                    <select name="rows[{{ $index }}][topSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                                        <option value="2" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XS' ? 'selected' : '' }}>XS</option>
                                        <option value="3" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="4" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="5" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'L' ? 'selected' : '' }}>L</option>
                                        <option value="6" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XL' ? 'selected' : '' }}>XL</option>
                                        <option value="7" {{ old('rows.'.$index.'.topSize', $row['topSize']) == 'XXL' ? 'selected' : '' }}>XXL</option>
                                    </select>
                                    <!-- Display validation error for 'topSize' field -->
                                    @error('rows.'.$index.'.topSize')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                    <select name="rows[{{ $index }}][shortSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">

                                        <option value="2" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XS' ? 'selected' : '' }}>XS</option>
                                        <option value="3" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="4" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="5" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'L' ? 'selected' : '' }}>L</option>
                                        <option value="6" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XL' ? 'selected' : '' }}>XL</option>
                                        <option value="7" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == 'XXL' ? 'selected' : '' }}>XXL</option>
                                    </select>
                                    <!-- Display validation error for 'shortSize' field -->
                                    @error('rows.'.$index.'.shortSize')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                <td class="p-2">
                                    <input type="hidden" name="rows[{{ $index }}][hasPocket]" value="0">
                                    <input type="checkbox" name="rows[{{ $index }}][hasPocket]" value="1" {{ old('rows.'.$index.'.hasPocket', $row['hasPocket'] ?? false) ? 'checked' : '' }} class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary focus:outline-none">
                                    @error('rows.'.$index.'.hasPocket')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>

                                </td>
                                <td class="p-2">
                                    <input type="text" name="rows[{{ $index }}][remarks]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white" value="{{ old('rows.'.$index.'.remarks', $row['remarks']) }}">
                                    <!-- Display validation error for 'remarks' field -->
                                    @error('rows.'.$index.'.remarks')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2 text-center">
                                    <button type="button" class="text-red-500 hover:text-red-700" onclick="removeRow(this)">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($errors->any())
                    <div class="text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="flex justify-start gap-x-3 mt-4">
                        <button type="button" class="flex bg-white border text-cPrimary border-cPrimary rounded-xl gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md hover:bg-gray-100 disabled:opacity-30 active:bg-gray-500" onclick="addRow()">
                            Add Row
                        </button>
                    </div>
                    <div class="flex justify-start mt-4">
                        <button type="submit" class="flex bg-cPrimary rounded-xl text-white text-[18px] px-6 py-3 justify-center transition ease-in-out hover:shadow-md disabled:opacity-30 active:bg-[#6B10A8]">
                            Confirm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('layout.footer')

    <script>
        let rowIndex = @json(count($rows));

        function addRow() {
            const rowsTable = document.getElementById('rowsTable');
            const newRow = `
                <tr class="odd:bg-gray-100 even:bg-white">
                    <td class="p-2 font-bold">${rowIndex + 1}</td>
                    <td class="p-2"><input type="text" name="rows[${rowIndex}][name]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                    <td class="p-2"><input type="text" name="rows[${rowIndex}][jerseyNo]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                    <td class="p-2">
                        <select name="rows[${rowIndex}][topSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                            <option value="">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </td>
                    <td class="p-2">
                        <select name="rows[${rowIndex}][shortSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                            <option value="">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </td>
                    <td class="p-2">
                        <input type="checkbox" name="rows[${rowIndex}][hasPocket]" class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary focus:outline-none">
                    </td>
                    <td class="p-2"><input type="text" name="rows[${rowIndex}][remarks]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                    <td class="p-2 text-center">
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="removeRow(this)">Delete</button>
                    </td>
                </tr>`;
            rowsTable.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#rowsTable tr');
            rows.forEach((row, index) => {
                row.querySelector('td').textContent = index + 1;
            });
        }
    </script>
</body>

</html>