<?php

namespace App\Imports;

use App\Models\SubType;
use Maatwebsite\Excel\Concerns\ToModel;

class SubTypeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubType([
            //
        ]);
    }
}
