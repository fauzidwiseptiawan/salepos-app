<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $now = date('Y-m-d H:i:s');
        return new Item([
            //
            'name' => $row['name'],
            'phone' => $row['desc'],
            'email' => $row['email'],
            'address' => $row['address'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
