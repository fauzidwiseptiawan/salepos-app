<!DOCTYPE html>
<html>

<head>
    <style>
        #item {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #item td,
        #item th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #item tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #item tr:hover {
            background-color: #ddd;
        }

        #item th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Item</h1>

    <table id="item">
        <tr>
            <th width="5%">No</th>
            <th>Kode Item</th>
            <th>Nama Item</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Jenis</th>
            <th>Merek</th>
            <th>Rak</th>
            <th>Harga Pokok</th>
            <th>Harga Jual</th>
            <th>Supplier</th>
            <th>Keterangan</th>
            <th>Gambar</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->item_code }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->unit->unit }}</td>
                <td>{{ $item->type->type }}</td>
                <td>{{ $item->brand->brand }}</td>
                <td>{{ $item->rack }}</td>
                <td>{{ $item->purchase_price }}</td>
                <td>{{ $item->selling_price }}</td>
                <td>{{ $item->supplier->supplier_name }}</td>
                <td>{{ $item->desc }}</td>
                @if ($item->image)
                    <td>
                        <img src="{{ public_path('storage/item-image/' . $item->image) }}"
                            alt="{{ public_path('storage/item-image/' . $item->image) }}" width="50%">
                    </td>
                @else
                    <td>
                        <img src="{{ public_path('template/dist/img/default.png') }}"
                            alt="{{ public_path('template/dist/img/default.png') }}" width="50%">
                    </td>
                @endif
            </tr>
        @endforeach
    </table>

</body>

</html>
