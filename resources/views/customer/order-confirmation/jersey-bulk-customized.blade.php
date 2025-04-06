<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('layout.nav')

    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section with Order Info -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-cPrimary">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span>Order Confirmation</span>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-cPrimary/10 flex items-center justify-center text-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="font-gilroy font-bold text-2xl text-gray-900">Jersey Customization</h1>
                            <p class="text-gray-500">Order No. <span class="font-medium text-gray-700">{{ $order->order_id }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Customer</p>
                            <p class="font-medium">{{$order->user->name}}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Order Date</p>
                            <p class="font-medium">{{$order->created_at->format('F j, Y')}}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-1">Apparel Type</p>
                            <p class="font-medium">Jersey Set</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="mb-4">
                    <h2 class="font-gilroy font-bold text-xl mb-2">Jersey Customization Details</h2>
                    <p class="text-gray-600">Please specify the details for each jersey to be printed. You must provide at least 10 customization entries.</p>
                </div>

                <!-- Excel Upload Option -->
                <div class="mb-6 p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <h3 class="font-medium text-lg text-purple-900 mb-2">Use Excel Template (Optional)</h3>
                    <p class="text-purple-800 mb-3">You can use our Excel template to specify your jersey customizations.</p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <a href="{{ route('excel.template', ['type' => 'jersey_bulk']) }}" class="inline-flex items-center px-4 py-2 border border-purple-300 rounded-md text-sm font-medium text-purple-700 bg-white hover:bg-purple-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download Excel Template
                        </a>
                    </div>

                    @if(session('format_issue'))
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200 mb-4">
                        <h4 class="font-medium text-red-700">Excel Format Issue Detected</h4>
                        <p class="text-red-600 mb-2">We've detected a format issue with your Excel file. For more reliable results, please use one of these options:</p>
                        <ol class="list-decimal pl-6 text-red-600 space-y-1 mb-3">
                            <li>Download and use our CSV template (recommended)</li>
                            <li>Ensure your Excel file has the exact required headers in row 1</li>
                            <li>Try saving your Excel file in CSV format</li>
                        </ol>

                        <div class="flex flex-col sm:flex-row gap-3 mt-3">
                            @if(session('emergency_template'))
                            <a href="{{ session('emergency_template') }}" class="inline-flex items-center px-3 py-1.5 bg-red-100 border border-red-300 rounded text-sm font-medium text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Download Emergency CSV Template
                            </a>
                            @endif

                            @if(session('emergency_bypass_url'))
                            <a href="{{ session('emergency_bypass_url') }}" class="inline-flex items-center px-3 py-1.5 bg-orange-100 border border-orange-300 rounded text-sm font-medium text-orange-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                </svg>
                                Use Emergency Default Data
                            </a>
                            @endif
                        </div>

                        <p class="text-xs text-red-500 mt-2">Note: The emergency option will use default sample data instead of your uploaded file.</p>
                    </div>
                    @endif

                    <form action="{{ route('excel.import.jersey-bulk') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <input type="hidden" name="token" value="{{ $order->token }}">

                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="flex-1">
                                <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls,.csv" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <p class="text-gray-500 text-xs mt-1">Accepted formats: .xlsx, .xls, .csv</p>
                            </div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Upload File
                            </button>
                        </div>
                    </form>

                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <p class="text-yellow-800 font-medium mb-2">Excel/CSV Import Requirements:</p>
                        <ul class="list-disc pl-6 text-yellow-700 text-sm space-y-1.5">
                            <li><strong>Headers must be in row 1:</strong> "name", "jersey_number", "top_size", "short_size", "has_pocket" (optional), "remarks" (optional)</li>
                            <li><strong>Jersey numbers:</strong> Can be numbers (10) or text ("10")</li>
                            <li><strong>Top/Short sizes:</strong> Must match one of these:
                                @foreach($sizes as $size)
                                <span class="font-medium">{{ $size->name }}</span>@if(!$loop->last), @endif
                                @endforeach
                            </li>
                            <li><strong>Has pocket:</strong> Use "yes", "no", 1, 0, or leave blank for no</li>
                            <li><strong>Required quantity:</strong> Minimum 10 rows of player data</li>
                        </ul>

                        <div class="mt-3 p-2 bg-white rounded border border-yellow-200">
                            <p class="text-yellow-800 font-medium">Troubleshooting Tips:</p>
                            <ul class="list-decimal pl-5 text-yellow-700 text-sm mt-1 space-y-1">
                                <li>If you experience Excel format issues, try using the CSV template instead</li>
                                <li>Ensure row 1 contains the exact headers listed above (all lowercase)</li>
                                <li>Fill in at least 10 rows with complete data (rows 2-11)</li>
                                <li>Do not modify the structure or add extra columns</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <p class="text-gray-600 mb-4">Or manually enter jersey details below:</p>

                <form action="{{ route('confirm-jerseybulk-custom-post') }}" method="POST" id="customizationForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <input type="hidden" name="token" value="{{ $order->token }}">

                    @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="overflow-hidden border border-gray-200 rounded-lg mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-cPrimary">
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-12">No.</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Player Name</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-24">Jersey #</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-28">Top Size</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-28">Short Size</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-20">Pocket</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Remarks</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-20">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="rowsTable" class="bg-white divide-y divide-gray-200">
                                    @foreach($rows as $index => $row)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-2 py-4 text-sm font-medium text-gray-900 align-top">{{ $index + 1 }}</td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][name]"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none"
                                                placeholder="Player name"
                                                value="{{ old('rows.'.$index.'.name', $row['name']) }}">
                                            @error('rows.'.$index.'.name')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][jerseyNo]"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none"
                                                placeholder="00"
                                                value="{{ old('rows.'.$index.'.jerseyNo', $row['jerseyNo']) }}">
                                            @error('rows.'.$index.'.jerseyNo')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <select name="rows[{{ $index }}][topSize]"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                                                <option value="">Select Size</option>
                                                @foreach($sizes as $size)
                                                <option value="{{ $size->sizes_ID }}" {{ old('rows.'.$index.'.topSize', $row['topSize']) == $size->sizes_ID ? 'selected' : '' }}>{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('rows.'.$index.'.topSize')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <select name="rows[{{ $index }}][shortSize]"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                                                <option value="">Select Size</option>
                                                @foreach($sizes as $size)
                                                <option value="{{ $size->sizes_ID }}" {{ old('rows.'.$index.'.shortSize', $row['shortSize']) == $size->sizes_ID ? 'selected' : '' }}>{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('rows.'.$index.'.shortSize')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500 text-center">
                                            <div class="flex justify-center">
                                                <input type="hidden" name="rows[{{ $index }}][hasPocket]" value="0">
                                                <input type="checkbox" name="rows[{{ $index }}][hasPocket]" value="1"
                                                    {{ old('rows.'.$index.'.hasPocket', $row['hasPocket'] ?? false) ? 'checked' : '' }}
                                                    class="w-5 h-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                                                @error('rows.'.$index.'.hasPocket')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <input type="text" name="rows[{{ $index }}][remarks]"
                                                class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none"
                                                placeholder="Optional notes"
                                                value="{{ old('rows.'.$index.'.remarks', $row['remarks']) }}">
                                            @error('rows.'.$index.'.remarks')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-2 py-4 text-sm text-gray-500">
                                            <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">You must have at least 10 customization entries.</span>
                        </div>
                        <div id="entry-counter" class="font-medium text-lg">Total Entries: <span id="total-entries">{{ count($rows) }}</span></div>
                    </div>

                    <!-- Hidden inputs for additional payment -->
                    <input type="hidden" name="new_total_price" id="new-total-price-input" value="0">
                    <input type="hidden" name="new_quantity" id="new-quantity-input" value="0">
                    <input type="hidden" name="additional_payment" id="additional-payment-input" value="0">

                    <!-- Alert message for additional payment -->
                    <div id="additional-payment-alert" class="hidden mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Additional payment required</h3>
                                <p class="mt-1 text-sm text-yellow-700">You have added more jerseys than the original order. You must pay the additional downpayment before confirming.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional payment summary section -->
                    <div id="additional-payment-section" class="hidden mb-6 bg-white border border-gray-200 rounded-lg p-4">
                        <h3 class="font-medium text-lg mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Original Quantity:</span>
                                <span class="font-medium">{{ $order->quantity }} jersey(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">New Quantity:</span>
                                <span id="summary-quantity" class="font-medium">0 jerseys</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Price:</span>
                                <span id="summary-total-price" class="font-medium">₱0.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Original Downpayment:</span>
                                <span class="font-medium">₱{{ number_format($order->downpayment_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Additional Payment:</span>
                                <span id="additional-payment" class="font-medium text-cPrimary">₱0.00</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Balance Due:</span>
                                    <span id="summary-balance" class="font-medium">₱0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <button type="button" onclick="addRow()" class="inline-flex items-center px-4 py-2 border border-cPrimary rounded-md shadow-sm text-sm font-medium text-cPrimary bg-white hover:bg-cPrimary/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Row
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Home
                        </a>

                        <div class="flex flex-row gap-x-4">
                            <!-- Additional payment button (hidden by default) -->
                            <button type="submit" id="pay-additional-btn" name="require_payment" value="1" class="hidden inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Pay Additional Payment
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Regular confirm button -->
                            <button type="submit" id="confirm-button" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-cPrimary hover:bg-cPrimary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cPrimary">
                                Confirm Order
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layout.footer')

    <script>
        let rowIndex = @json(count($rows));

        function addRow() {
            console.log('Add row function called');
            const rowsTable = document.getElementById('rowsTable');
            console.log('Found rows table:', rowsTable);
            const rowCount = rowsTable.rows.length;
            console.log('Current row count:', rowCount);
            const isOdd = rowCount % 2;

            // Generate size options dynamically using PHP $sizes collection
            let topSizeOptions = '';
            let shortSizeOptions = '';

            @foreach($sizes as $size)
            topSizeOptions += `<option value="{{ $size->sizes_ID }}">{{ $size->name }}</option>`;
            shortSizeOptions += `<option value="{{ $size->sizes_ID }}">{{ $size->name }}</option>`;
            @endforeach

            const newRow = `
                <tr class="${isOdd ? 'bg-gray-50' : 'bg-white'}">
                    <td class="px-2 py-4 text-sm font-medium text-gray-900 align-top">${rowCount + 1}</td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][name]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Player name">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][jerseyNo]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="00">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <select name="rows[${rowCount}][topSize]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                            <option value="">Select Size</option>
                            ${topSizeOptions}
                        </select>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <select name="rows[${rowCount}][shortSize]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none">
                            <option value="">Select Size</option>
                            ${shortSizeOptions}
                        </select>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500 text-center">
                        <div class="flex justify-center">
                            <input type="hidden" name="rows[${rowCount}][hasPocket]" value="0">
                            <input type="checkbox" name="rows[${rowCount}][hasPocket]" value="1" 
                                class="w-5 h-5 text-cPrimary border-gray-300 rounded focus:ring-cPrimary">
                        </div>
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <input type="text" name="rows[${rowCount}][remarks]" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-cPrimary focus:border-cPrimary focus:outline-none" 
                            placeholder="Optional notes">
                    </td>
                    <td class="px-2 py-4 text-sm text-gray-500">
                        <button type="button" onclick="removeRow(this)" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </td>
                </tr>`;

            console.log('Inserting new row');
            rowsTable.insertAdjacentHTML('beforeend', newRow);
            rowIndex++;
            console.log('New row index:', rowIndex);
            updateEntryCount();
            console.log('Updated entry count');
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowNumbers();
            updateEntryCount();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#rowsTable tr');
            rows.forEach((row, index) => {
                row.firstElementChild.textContent = index + 1;
                // Update classes for zebra striping
                if (index % 2 === 0) {
                    row.classList.remove('bg-gray-50');
                    row.classList.add('bg-white');
                } else {
                    row.classList.remove('bg-white');
                    row.classList.add('bg-gray-50');
                }
            });
        }

        function updateEntryCount() {
            const totalEntriesElement = document.getElementById('total-entries');
            const entryCounterElement = document.getElementById('entry-counter');
            const rows = document.querySelectorAll('#rowsTable tr');
            const count = rows.length;

            totalEntriesElement.textContent = count;

            // Get references to UI elements
            const additionalPaymentSection = document.getElementById('additional-payment-section');
            const additionalPaymentAlert = document.getElementById('additional-payment-alert');
            const payAdditionalBtn = document.getElementById('pay-additional-btn');
            const confirmButton = document.getElementById('confirm-button');

            // Get original quantity value from the server-side data
            const originalQuantity = {{ $order->quantity }};

            if (count >= 10) {
                entryCounterElement.classList.remove('text-red-500');
                entryCounterElement.classList.add('text-green-600');

                // Check if quantity has increased compared to original order
                if (count > originalQuantity) {
                    // Show additional payment UI
                    additionalPaymentSection.classList.remove('hidden');
                    additionalPaymentAlert.classList.remove('hidden');
                    payAdditionalBtn.classList.remove('hidden');

                    // Disable regular confirm button
                    confirmButton.disabled = true;
                    confirmButton.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    confirmButton.classList.remove('bg-cPrimary', 'hover:bg-cPrimary/90');

                    // Calculate additional payment info
                    updateOrderSummary(count);
                } else {
                    // Hide additional payment UI
                    additionalPaymentSection.classList.add('hidden');
                    additionalPaymentAlert.classList.add('hidden');
                    payAdditionalBtn.classList.add('hidden');

                    // Enable regular confirm button
                    confirmButton.disabled = false;
                    confirmButton.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    confirmButton.classList.add('bg-cPrimary', 'hover:bg-cPrimary/90');
                }
            } else {
                entryCounterElement.classList.remove('text-green-600');
                entryCounterElement.classList.add('text-red-500');

                // Disable confirm button if count is invalid
                confirmButton.disabled = true;
                confirmButton.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                confirmButton.classList.remove('bg-cPrimary', 'hover:bg-cPrimary/90');

                // Hide additional payment UI
                additionalPaymentSection.classList.add('hidden');
                additionalPaymentAlert.classList.add('hidden');
                payAdditionalBtn.classList.add('hidden');
            }
        }

        function updateOrderSummary(totalQuantity) {
            // Get original values from server-side data
            const originalQuantity = {{ $order->quantity }};
            const unitPrice = {{ $order->final_price / $order->quantity }};
            const originalDownpayment = {{ $order->downpayment_amount }};

            // Calculate new values
            const totalPrice = unitPrice * totalQuantity;
            const additionalQuantity = Math.max(0, totalQuantity - originalQuantity);
            const additionalPaymentAmount = (additionalQuantity * unitPrice) / 2; // 50% down payment for additional items
            const balanceDue = totalPrice - originalDownpayment - additionalPaymentAmount;

            // Update display
            document.getElementById('summary-quantity').textContent = totalQuantity + ' jersey' + (totalQuantity !== 1 ? 's' : '');
            document.getElementById('summary-total-price').textContent = '₱' + totalPrice.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('summary-balance').textContent = '₱' + Math.max(0, balanceDue).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            if (additionalPaymentAmount > 0) {
                document.getElementById('additional-payment').textContent = '₱' + additionalPaymentAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Update hidden inputs for form submission
            document.getElementById('new-total-price-input').value = totalPrice.toFixed(2);
            document.getElementById('new-quantity-input').value = totalQuantity;
            document.getElementById('additional-payment-input').value = additionalPaymentAmount.toFixed(2);

            // Update hidden inputs for the form
            document.getElementById('additional-payment-input').value = additionalPaymentAmount.toFixed(2);
            document.getElementById('new-quantity-input').value = totalQuantity;
            
            // Make sure the Pay Additional button is visible when there's additional payment
            if (additionalPaymentAmount > 0) {
                const payAdditionalBtn = document.getElementById('pay-additional-btn');
                if (payAdditionalBtn) {
                    payAdditionalBtn.classList.remove('hidden');
                    
                    // Enable the Pay Additional button
                    payAdditionalBtn.disabled = false;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the form
            updateEntryCount();

            // Add event listener for form submission
            document.getElementById('customizationForm').addEventListener('submit', function(e) {
                const rows = document.querySelectorAll('#rowsTable tr');
                if (rows.length < 10) {
                    e.preventDefault();
                    alert('You must have at least 10 customization entries to proceed.');
                    return false;
                }
                return true;
            });

            // Add event listener for the pay additional button
            const payAdditionalBtn = document.getElementById('pay-additional-btn');
            if (payAdditionalBtn) {
                payAdditionalBtn.addEventListener('click', function(e) {
                    // Form validation before proceeding to payment
                    const formData = collectFormData();
                    if (formData.length < 10) {
                        e.preventDefault();
                        alert('You must have at least 10 valid jersey entries before proceeding to payment.');
                        return;
                    }

                    // Make sure the form has the right action and add a hidden flag for additional payment
                    const form = document.getElementById('customizationForm');
                    
                    // Create hidden input for requiring additional payment if it doesn't exist
                    if (!document.getElementById('require_payment_input')) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'require_payment';
                        hiddenInput.id = 'require_payment_input';
                        hiddenInput.value = '1';
                        form.appendChild(hiddenInput);
                    }
                    
                    console.log('Form ready for additional payment submission');
                });
            }
        });

        function collectFormData() {
            const rows = document.querySelectorAll('#rowsTable tr');
            const formData = [];

            rows.forEach((row, index) => {
                const nameInput = row.querySelector('input[name^="rows["][name$="][name]"]');
                const remarksInput = row.querySelector('input[name^="rows["][name$="][remarks]"]');
                const jerseyNoInput = row.querySelector('input[name^="rows["][name$="][jerseyNo]"]');
                const topSizeSelect = row.querySelector('select[name^="rows["][name$="][topSize]"]');
                const shortSizeSelect = row.querySelector('select[name^="rows["][name$="][shortSize]"]');
                const hasPocketCheckbox = row.querySelector('input[name^="rows["][name$="][hasPocket]"][type="checkbox"]');

                // Only include row if required fields are filled
                if (nameInput && nameInput.value &&
                    jerseyNoInput && jerseyNoInput.value &&
                    topSizeSelect && topSizeSelect.value &&
                    shortSizeSelect && shortSizeSelect.value) {

                    const rowData = {
                        name: nameInput.value,
                        jerseyNo: jerseyNoInput.value,
                        topSize: topSizeSelect.value,
                        shortSize: shortSizeSelect.value,
                        hasPocket: hasPocketCheckbox ? hasPocketCheckbox.checked : false,
                        remarks: remarksInput ? remarksInput.value : ''
                    };

                    formData.push(rowData);
                }
            });

            return formData;
        }

        // collectFormData function is used for validation and data collection
    </script>
</body>

</html>