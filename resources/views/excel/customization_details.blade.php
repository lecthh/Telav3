<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customization Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Customization Details for Order: {{ $order->order_id }}</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Apparel Type</th>
                <th>Top Size</th>
                @foreach ($customizations as $customization)
                @if ($order->apparelType->name == 'Jersey')
                <th>Jersey No.</th>
                <th>Short Size</th>
                <th>Has Pocket</th>
                @break
                @endif
                @endforeach
                <th>Remarks</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQuantity = 0; @endphp
            @foreach ($customizations as $index => $customization)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $customization->name }}</td>
                <td>{{ $order->apparelType->name }}</td>
                <td>{{ $customization->size->name ?? 'N/A' }}</td>
                @if ($order->apparelType->name == 'Jersey')
                <td>{{ $customization->jersey_no }}</td>
                <td>{{ $customization->short_size }}</td>
                <td>{{ $customization->has_pocket ? 'Yes' : 'No' }}</td>
                @endif

                <td>{{ $customization->remarks }}</td>
                <td>{{ $customization->quantity }}</td>
            </tr>
            @php $totalQuantity += $customization->quantity; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ $order->apparelType->name == 'Jersey' ? 9 : 5 }}"><strong>Total Quantity</strong></td>
                <td>{{ $totalQuantity }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>