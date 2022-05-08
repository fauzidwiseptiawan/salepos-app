<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class supplierImport implements ToModel, WithHeadingRow
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
        return new supplier([
            //
            'supplier_code' => $row['supplier_code'],
            'supplier_name' => $row['supplier_name'],
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
