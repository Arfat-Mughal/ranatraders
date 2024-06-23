<?php

namespace App\Imports;

use App\Models\Transaction;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Validators\Failure;

class TransactionsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsFailures, WithEvents, Importable, SkipsErrors, SkipsOnFailure
{
    use Importable, RegistersEventListeners;

    private $company_id;

    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new Transaction([
            'date' => $row['Date'],
            'payment_method' => $row['BANK PAYMENT/ AND DETAIL'] ?? $row['BANK'], // Use BANK PAYMENT/ AND DETAIL or BANK if former is empty
            'other_detail' => $row['BANK PAYMENT/ AND DETAIL'] ?? $row['Other Detail'],
            'truck_no' => $row['Truck No.'],
            'weight' => $row['Weight'],
            'rate' => $row['Rate'],
            'gravity' => $row['Gravity'],
            'letter' => $row['Letter'],
            'debit' => $row['Debit'],
            'credit' => $row['Credit'],
            'balance' => $row['Balance'],
            'company_id' => $this->company_id,
        ]);
    }

    public function rules(): array
    {
        return [
            'Date' => 'required|date',
            'BANK PAYMENT/ AND DETAIL' => 'required|string',
            'BANK' => 'required|string',
            'Truck No.' => 'nullable|string',
            'Weight' => 'nullable|numeric',
            'Rate' => 'nullable|numeric',
            'Gravity' => 'nullable|numeric',
            'Letter' => 'nullable|string',
            'Debit' => 'nullable|numeric',
            'Credit' => 'nullable|numeric',
            'Balance' => 'required|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'Date.required' => 'Date is required.',
            'Date.date' => 'Date must be a valid date.',
            'BANK PAYMENT/ AND DETAIL.required' => 'Payment Method or Detail (BANK PAYMENT/ AND DETAIL) is required.',
            'BANK.required' => 'Bank is required.',
            'Truck No.' => 'Truck No. must be a string.',
            'Weight.numeric' => 'Weight must be numeric.',
            'Rate.numeric' => 'Rate must be numeric.',
            'Gravity.numeric' => 'Gravity must be numeric.',
            'Debit.numeric' => 'Debit must be numeric.',
            'Credit.numeric' => 'Credit must be numeric.',
            'Balance.required' => 'Balance is required.',
            'Balance.numeric' => 'Balance must be numeric.',
        ];
    }
}

