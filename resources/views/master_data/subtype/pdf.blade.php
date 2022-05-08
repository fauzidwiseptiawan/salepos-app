<!DOCTYPE html>
<html>

<head>
    <style>
        #subtype {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #subtype td,
        #subtype th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #subtype tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #subtype tr:hover {
            background-color: #ddd;
        }

        #subtype th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Sub Jenis</h1>

    <table id="subtype">
        <tr>
            <th width="10%">No</th>
            <th>Sub Jenis</th>
            <th>Keterangan</th>
            <th>Jenis</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->subtype }}</td>
                <td>{{ $item->type->type }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
