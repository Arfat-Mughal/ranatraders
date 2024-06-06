<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'date',
        'payment_method',
        'other_detail',
        'truck_no',
        'weight',
        'rate',
        'gravity',
        'letter',
        'debit',
        'credit',
        'balance'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
