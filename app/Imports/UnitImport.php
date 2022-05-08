<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitImport implements ToModel, WithHeadingRow
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
        return new Unit([
            //
            'unit' => $row['unit'],
            'desc' => $row['desc'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
