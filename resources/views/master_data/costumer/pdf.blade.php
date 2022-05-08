<!DOCTYPE html>
<html>

<head>
    <style>
        #costumer {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #costumer td,
        #costumer th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #costumer tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #costumer tr:hover {
            background-color: #ddd;
        }

        #costumer th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar costumer</h1>

    <table id="costumer">
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
                <td>{{ $item->costumer_code }}</td>
                <td>{{ $item->costumer_name }}</td>
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
