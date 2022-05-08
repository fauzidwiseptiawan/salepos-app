<!DOCTYPE html>
<html>

<head>
    <style>
        #supplier {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #supplier td,
        #supplier th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #supplier tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #supplier tr:hover {
            background-color: #ddd;
        }

        #supplier th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Supplier</h1>

    <table id="supplier">
        <tr>
            <th width="5%">No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Kota</th>
            <th>Provinsi</th>
            <th>Alamat</th>
            <th>Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->supplier_code }}</td>
                <td>{{ $item->supplier_name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->city }}</td>
                <td>{{ $item->province }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
