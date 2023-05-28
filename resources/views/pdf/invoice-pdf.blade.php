<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FlowTranslate - Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top">
                <h1>Flow Translate</h1>
            </td>
            <td align="right">
                <h3>Order ID:{{ $data->order_id }}</h3>
                <pre>
                info@flowtranslate.com
                650-229-4621
            </pre>
            </td>
        </tr>

    </table>

    <table width="100%">
        <tr>
            <td><strong>From:</strong> info@flowtranslate.com</td>
            <td><strong>To:</strong> {{ $data->user->email }}</td>
        </tr>

    </table>

    <br />

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Language(s)</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Submitted At</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- {{ dd($data) }} --}}
                <th scope="row">1</th>
                <td>{{ $data->order->language1 }}, {{ $data->order->language2 }}</td>
                <td>{{ $data->description }}</td>
                <td align="right">{{ $data->docQuantity }}</td>
                <td align="right">
                    {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($data->created_at, request()->ip()) }}</td>
                <td align="right">${{ $data->amount }}</td>
                {{-- <td align="right">{{ $data->invoice-> }}</td> --}}
            </tr>
        </tbody>

        {{-- <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Total $</td>
                <td align="right" class="gray">${{ $data->amount }}</td>
            </tr>
        </tfoot> --}}
    </table>

</body>

</html>
