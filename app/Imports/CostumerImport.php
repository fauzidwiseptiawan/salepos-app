<?php

namespace App\Imports;

use App\Models\Costumer;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class costumerImport implements ToModel, WithHeadingRow
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
        return new costumer([
            //
            'costumer_code' => $row['costumer_code'],
            'costumer_name' => $row['costumer_name'],
            'phone' => $row['desc'],
            'email' => $row['email'],
            'city' => $row['city'],
            'province' => $row['province'],
            'address' => $row['address'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
