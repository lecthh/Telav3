<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="h-screen flex flex-col">
    <div class="flex flex-col flex-grow">
        @include('layout.nav')

        <div class="flex-grow overflow-y-auto px-[200px] py-[100px] bg-white">
            <div class="flex flex-col gap-y-3">
                <h3 class="font-gilroy font-bold text-5xl">Order Confirmation</h3>
                <h5 class="font-inter text-base">Order No. {{ $order->order_id }}</h5>
            </div>

            <form action="{{ route('confirm-bulk-custom-post') }}" method="POST" id="customizationForm">
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
                                <th class="p-3 text-start">Size</th>
                                <th class="p-3 text-start">Remarks</th>
                                <th class="p-3 text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border" id="rowsTable">
                            @foreach ($rows as $index => $row)
                            <tr class="odd:bg-gray-100 even:bg-white">
                                <td class="p-2 font-bold">{{ $index + 1 }}</td>
                                <td class="p-2">
                                    <input type="text" name="rows[{{ $index }}][name]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white" value="{{ old('rows.'.$index.'.name') }}">
                                    @error("rows.$index.name")
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                    <select name="rows[{{ $index }}][size]" class="w-[80px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                                        <option value="">Select Size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->sizes_ID }}" {{ old('rows.'.$index.'.size') == $size->sizes_ID ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("rows.$index.size")
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="p-2">
                                    <input type="text" name="rows[{{ $index }}][remarks]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white" value="{{ old('rows.'.$index.'.remarks') }}">
                                    @error("rows.$index.remarks")
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
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
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

        <footer class="w-full">
            @include('layout.footer')
        </footer>
    </div>

    <script>
        function addRow() {
            const rowsTable = document.getElementById('rowsTable');
            const rowCount = rowsTable.rows.length;
            const sizesOptions = `@foreach($sizes as $size)<option value="{{ $size->sizes_ID }}">{{ $size->name }}</option>@endforeach`;

            const newRow = `
                <tr class="odd:bg-gray-100 even:bg-white">
                    <td class="p-2 font-bold">${rowCount + 1}</td>
                    <td class="p-2">
                        <input type="text" name="rows[${rowCount}][name]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white">
                    </td>
                    <td class="p-2">
                        <select name="rows[${rowCount}][size]" class="w-[80px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                            <option value="">Select Size</option>
                            ${sizesOptions}
                        </select>
                    </td>
                    <td class="p-2">
                        <input type="text" name="rows[${rowCount}][remarks]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white">
                    </td>
                    <td class="p-2 text-center">
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="removeRow(this)">Delete</button>
                    </td>
                </tr>`;
            rowsTable.insertAdjacentHTML('beforeend', newRow);
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