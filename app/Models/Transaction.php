<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
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
        'balance',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function from_customers()
    {
        return $this->belongsTo(Customer::class, 'from_customer');
    }

    public function to_customers()
    {
        return $this->belongsTo(Customer::class, 'to_customer');
    }
}
