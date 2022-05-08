<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandImport implements ToModel, WithHeadingRow
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
        return new Brand([
            'brand' => $row['brand'],
            'desc' => $row['desc'],
            'image' => $row['image'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
