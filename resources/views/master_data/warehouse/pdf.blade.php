<!DOCTYPE html>
<html>

<head>
    <style>
        #warehouse {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #warehouse td,
        #warehouse th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #warehouse tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #warehouse tr:hover {
            background-color: #ddd;
        }

        #warehouse th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Gudang</h1>

    <table id="warehouse">
        <tr>
            <th width="10%">No</th>
            <th>Gudang</th>
            <th>Telpon</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
