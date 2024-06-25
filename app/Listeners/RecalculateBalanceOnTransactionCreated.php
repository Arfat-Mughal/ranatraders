<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecalculateBalanceOnTransactionCreated implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(TransactionCreated $event)
    {
        // Update balances of related transactions
        $this->recalculateBalances($event->transaction);
    }

    protected function recalculateBalances(Transaction $transaction)
    {
        // Logic to recalculate balances, for example:
        $company_id = $transaction->company_id;
        $transactions = Transaction::where('company_id', $company_id)
            // ->where('date', '>=', $transaction->date)
            ->orderBy('date', 'asc')
            ->get();

        $balance = 0;
        foreach ($transactions as $trx) {
            $balance += $trx->credit - $trx->debit;
            $trx->balance = $balance;
            $trx->save();
        }
    }
}

