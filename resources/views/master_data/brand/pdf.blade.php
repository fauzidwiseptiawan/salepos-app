<!DOCTYPE html>
<html>

<head>
    <style>
        #brand {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #brand td,
        #brand th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #brand tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #brand tr:hover {
            background-color: #ddd;
        }

        #brand th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

    </style>
</head>

<body>

    <h1>Laporan Daftar Merek</h1>

    <table id="brand">
        <tr>
            <th width="10%">No</th>
            <th>Gambar</th>
            <th>Merek</th>
            <th>Keterangan</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td>{{ $no++ }}</td>
                @if ($item->image)
                    <td>
                        <img src="{{ public_path('storage/brand-image/' . $item->image) }}"
                            alt="{{ public_path('storage/brand-image/' . $item->image) }}" width="50%">
                    </td>
                @else
                    <td>
                        <img src="{{ public_path('template/dist/img/default.png') }}"
                            alt="{{ public_path('template/dist/img/default.png') }}" width="50%">
                    </td>
                @endif
                <td>{{ $item->brand }}</td>
                <td>{{ $item->desc }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
