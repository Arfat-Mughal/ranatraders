<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['company_id', 'type', 'description', 'amount', 'date'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
