<!DOCTYPE html>
<html>

<head>
    <style>
        #unit {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #unit td,
        #unit th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #unit tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #unit tr:hover {
            background-color: #ddd;
        }

        #unit th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Satuan</h1>

    <table id="unit">
        <tr>
            <th width="10%">No</th>
            <th>Satuan</th>
            <th>Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
