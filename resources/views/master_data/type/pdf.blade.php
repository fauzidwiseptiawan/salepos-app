<!DOCTYPE html>
<html>

<head>
    <style>
        #type {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #type td,
        #type th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #type tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #type tr:hover {
            background-color: #ddd;
        }

        #type th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Jenis</h1>

    <table id="type">
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
                <td>{{ $item->type }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
