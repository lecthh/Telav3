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
        <tbody class="border">
            @foreach ($rows as $index => $row)
            <tr class="odd:bg-gray-100 even:bg-white">
                <td class="p-2 font-bold">{{ $index + 1 }}</td>
                <td class="p-2"><input type="text" name="rows[{{ $index }}][name]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                <td class="p-2"><input type="text" name="rows[{{ $index }}][jerseyNo]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                <td class="p-2">
                    <select name="rows[{{ $index }}][topSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                        <option value="">XS</option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                        <option value="">XL</option>
                        <option value="">XXL</option>
                    </select>
                </td>
                <td class="p-2">
                    <select name="rows[{{ $index }}][shortSize]" class="w-[90px] h-10 rounded border-gray-300 odd:bg-gray-100 even:bg-white">
                        <option value="">XS</option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                        <option value="">XL</option>
                        <option value="">XXL</option>
                    </select>
                </td>
                <td class="p-2"> <input type="checkbox" id="" value="" class="cart-checkbox border border-black w-4 h-4 p-1 py-1 rounded checked:bg-cPrimary checked:hover:bg-cPrimary checked:active:bg-cPrimary checked:focus:bg-cPrimary focus:bg-cPrimary focus:outline-none focus:ring-1 focus:ring-cPrimary">
                </td>
                <td class="p-2"><input type="text" name="rows[{{ $index }}][remarks]" class="border-gray-300 rounded odd:bg-gray-100 even:bg-white"></td>
                <td class="p-2 text-center">
                    <button type="button" wire:click="deleteRow({{ $index }})" class="text-red-500 hover:text-red-700">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-start gap-x-3 mt-4">
        <button type="button" wire:click="addRow" class="flex bg-white border text-cPrimary border-cPrimary rounded-xl gap-y-3 px-6 py-3 justify-center transition ease-in-out hover:shadow-md hover:bg-gray-100 disabled:opacity-30 active:bg-gray-500">
            Add Row
        </button>
    </div>
</div>