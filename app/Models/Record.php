<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'company_id', 'date', 'dn', 'type', 'rate', 'liter', 'amount'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
