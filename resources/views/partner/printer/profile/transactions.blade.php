@include('head', ['title' => 'Transactions'])
<x-blocked-banner-wrapper :entity="$productionCompany" />
<header class="bg-cPrimary text-white py-2 text-center font-gilroy font-bold text-sm">
    Production Hub
</header>
<div class="flex bg-gray-100">
    @include('layout.printer')
    <div class="p-6 w-full">
        <div class="max-w-full mx-auto">
            <div class="mb-6">
                <h1 class="text-3xl font-gilroy font-bold text-gray-900">Transaction History</h1>
                <p class="text-gray-600 mt-1">View payment history and upload receipts for customer payments</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm mb-8 p-6">
                <h2 class="text-xl font-gilroy font-semibold mb-4">Active Orders</h2>

                @if($activeOrders->isEmpty())
                <div class="text-gray-500 italic">No active orders found</div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Order ID</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Customer</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Total Price</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Downpayment</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Additional Payments</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Balance Due</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeOrders as $order)
                            @php
                            $additionalPaymentsTotal = $order->additionalPayments->sum('amount');
                            $balanceReceiptsTotal = $order->balanceReceipts->sum('amount');
                            $totalPaid = $order->downpayment_amount + $additionalPaymentsTotal + $balanceReceiptsTotal;
                            $balanceDue = max(0, $order->final_price - $totalPaid); // Prevent negative balance
                            $overpayment = ($totalPaid > $order->final_price) ? ($totalPaid - $order->final_price) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-3 text-sm text-gray-900">#{{ $order->order_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @switch($order->status_id)
                                    @case(1)
                                    <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded-full text-xs font-medium">Pending</span>
                                    @break
                                    @case(2)
                                    <span class="text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full text-xs font-medium">Design in Progress</span>
                                    @break
                                    @case(3)
                                    <span class="text-purple-600 bg-purple-50 px-2 py-1 rounded-full text-xs font-medium">Finalize</span>
                                    @break
                                    @case(4)
                                    <span class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full text-xs font-medium">Awaiting Printing</span>
                                    @break
                                    @case(5)
                                    <span class="text-orange-600 bg-orange-50 px-2 py-1 rounded-full text-xs font-medium">Printing in Progress</span>
                                    @break
                                    @case(6)
                                    <span class="text-green-600 bg-green-50 px-2 py-1 rounded-full text-xs font-medium">Ready for Collection</span>
                                    @break
                                    @case(7)
                                    <span class="text-gray-600 bg-gray-50 px-2 py-1 rounded-full text-xs font-medium">Completed</span>
                                    @break
                                    @default
                                    <span class="text-gray-600 bg-gray-50 px-2 py-1 rounded-full text-xs font-medium">Unknown</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">₱{{ number_format($order->final_price, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <span class="mr-2">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                                        <a href="{{ route('order.receipt') }}?order_id={{ $order->order_id }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Receipt</a>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($order->additionalPayments->isNotEmpty())
                                    <div class="flex flex-col">
                                        @foreach($order->additionalPayments as $payment)
                                        <div class="mb-1 flex items-center">
                                            <span class="mr-2">₱{{ number_format($payment->amount, 2) }}</span>
                                            <a href="{{ asset('storage/'.$payment->payment_proof) }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Receipt</a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <span class="text-gray-500">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-col">
                                        @if($balanceDue > 0)
                                        <span class="font-medium text-red-600">
                                            ₱{{ number_format($balanceDue, 2) }}
                                        </span>
                                        @elseif($overpayment > 0)
                                        <span class="font-medium text-green-600">
                                            ₱0.00 <span class="text-xs">(Overpaid: ₱{{ number_format($overpayment, 2) }})</span>
                                        </span>
                                        @else
                                        <span class="font-medium text-green-600">
                                            ₱0.00
                                        </span>
                                        @endif

                                        @if($order->balanceReceipts->isNotEmpty())
                                        <div class="mt-1">
                                            @foreach($order->balanceReceipts as $receipt)
                                            <div class="mb-1 flex items-center">
                                                <span class="text-xs text-gray-500 mr-1">Paid ₱{{ number_format($receipt->amount, 2) }}</span>
                                                <a href="{{ asset('storage/'.$receipt->receipt_image_path) }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Receipt</a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($balanceDue > 0)
                                    <button
                                        onclick="showUploadModal('{{ $order->order_id }}', '{{ number_format($balanceDue, 2) }}')"
                                        class="text-cPrimary hover:text-cPrimary-dark focus:outline-none text-sm font-medium">
                                        Upload Receipt
                                    </button>
                                    @else
                                    <span class="text-green-600 text-sm font-medium">Fully Paid</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-gilroy font-semibold mb-4">Completed Orders</h2>

                @if($completedOrders->isEmpty())
                <div class="text-gray-500 italic">No completed orders found</div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Order ID</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Customer</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Completion Date</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Total Price</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Downpayment</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Additional Payments</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Balance Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedOrders->where('status_id', 7) as $order)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-3 text-sm text-gray-900">#{{ $order->order_id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $order->updated_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">₱{{ number_format($order->final_price, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <span class="mr-2">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                                        <a href="{{ route('order.receipt') }}?order_id={{ $order->order_id }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Checkout Receipt</a>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($order->additionalPayments->isNotEmpty())
                                    <div class="flex flex-col">
                                        @foreach($order->additionalPayments as $payment)
                                        <div class="mb-1 flex items-center">
                                            <span class="mr-2">₱{{ number_format($payment->amount, 2) }}</span>
                                            <a href="{{ asset('storage/'.$payment->payment_proof) }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Receipt</a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <span class="text-gray-500">None</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($order->balanceReceipts->isNotEmpty())
                                    <div class="flex flex-col">
                                        @foreach($order->balanceReceipts as $receipt)
                                        <div class="mb-1 flex items-center">
                                            <span class="mr-2">₱{{ number_format($receipt->amount, 2) }}</span>
                                            <a href="{{ asset('storage/'.$receipt->receipt_image_path) }}" target="_blank" class="text-cPrimary hover:underline text-xs">View Receipt</a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <span class="text-gray-500">No receipt uploaded</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Upload Receipt Modal -->
    <div id="uploadReceiptModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button id="closeModal" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modalTitle">Upload Payment Receipt</h3>
                        <form id="receiptForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" step="0.01" class="focus:ring-cPrimary focus:border-cPrimary block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Balance due: <span id="balanceDueText">₱0.00</span></p>
                            </div>

                            <div>
                                <label for="receipt_image" class="block text-sm font-medium text-gray-700">Receipt Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="receipt_image" class="relative cursor-pointer bg-white rounded-md font-medium text-cPrimary hover:text-cPrimary-dark focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="receipt_image" name="receipt_image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                <div class="mt-1">
                                    <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-cPrimary focus:border-cPrimary block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter any additional notes here..."></textarea>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-cPrimary text-base font-medium text-white hover:bg-cPrimary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary sm:text-sm">
                                    Upload Receipt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showUploadModal(orderId, balanceDue) {
        // Set form action
        document.getElementById('receiptForm').action = "{{ route('partner.printer.profile.upload-receipt', '') }}/" + orderId;

        // Set balance due text
        document.getElementById('balanceDueText').textContent = '₱' + balanceDue;

        // Pre-fill the amount field with the balance due (removing ₱ and commas)
        const amountValue = balanceDue.replace('₱', '').replace(/,/g, '');
        document.getElementById('amount').value = amountValue;

        // Show modal
        document.getElementById('uploadReceiptModal').classList.remove('hidden');
    }

    // Close modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('uploadReceiptModal').classList.add('hidden');
    });

    // Close modal on background click
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('uploadReceiptModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Prevent file input from closing modal when clicking on it
    document.querySelector('.focus-within\\:outline-none').addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>