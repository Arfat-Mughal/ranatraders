<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Transaction extends Model
{
    use LogsActivity;

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

    /**
     * Get the options for activity logging.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
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
            ])
            ->logOnlyDirty()
            ->useLogName('transaction');
    }

    /**
     * Get a description for the given event.
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Transaction has been {$eventName}";
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    
}
