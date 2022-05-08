<?php

namespace App\Imports;

use App\Models\Bank;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class bankImport implements ToModel, WithHeadingRow
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
        return new Bank([
            //
            'bank' => $row['bank'],
            'desc' => $row['desc'],
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
