<!DOCTYPE html>
<html>

<head>
    <style>
        #bank {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #bank td,
        #bank th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #bank tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #bank tr:hover {
            background-color: #ddd;
        }

        #bank th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Bank</h1>

    <table id="bank">
        <tr>
            <th width="10%">No</th>
            <th>Bank</th>
            <th>Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->bank }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
