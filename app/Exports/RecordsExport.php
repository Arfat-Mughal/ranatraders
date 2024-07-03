<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class RecordsExport implements FromQuery
{
    use Exportable;

    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function query()
    {
        return Record::query()->where('company_id', $this->companyId);
    }
}
