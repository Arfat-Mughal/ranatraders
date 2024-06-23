<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $company_id;
    protected $start_date;
    protected $end_date;

    public function __construct($company_id, $start_date = null, $end_date = null)
    {
        $this->company_id = $company_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $query = Transaction::where('company_id', $this->company_id);

        if ($this->start_date) {
            $query->where('date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->where('date', '<=', $this->end_date);
        }

        return $query->with('company')
                     ->orderBy('date', 'desc')
                     ->get()
                     ->map(function($transaction) {
            return [
                'Sr.No' => $transaction->id,
                'Date' => $transaction->date,
                'Payment Method' => $transaction->payment_method,
                'Other Detail' => $transaction->other_detail,
                'Truck No' => $transaction->truck_no,
                'Weight' => $transaction->weight,
                'Rate' => $transaction->rate,
                'Gravity' => $transaction->gravity,
                'Letter' => $transaction->letter,
                'Debit' => $transaction->debit,
                'Credit' => $transaction->credit,
                'Balance' => $transaction->balance,
                'Company' => $transaction->company->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr.No',
            'Date',
            'Payment Method',
            'Other Detail',
            'Truck No',
            'Weight',
            'Rate',
            'Gravity',
            'Letter',
            'Debit',
            'Credit',
            'Balance',
            'Company',
        ];
    }
}

