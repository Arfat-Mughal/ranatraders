<?php

namespace App\Imports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;

class RecordsImport implements ToModel
{
    public function model(array $row)
    {
        return new Record([
            'company_id' => $row[0],
            'date' => $row[1],
            'dn' => $row[2],
            'type' => $row[3],
            'rate' => $row[4],
            'liter' => $row[5],
            'amount' => $row[6],
        ]);
    }
}
