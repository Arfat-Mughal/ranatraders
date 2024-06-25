<?php

namespace App\Listeners;

use App\Events\TransactionDeleted;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateBalanceOnTransactionDeleted implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(TransactionDeleted $event)
    {
        // Update balances of related transactions
        $this->recalculateBalances($event->transaction);
    }

    protected function recalculateBalances(Transaction $transaction)
    {
        $company_id = $transaction->company_id;
        $transactions = Transaction::where('company_id', $company_id)
            ->whereNotIn('id', [$transaction->id])
            ->orderBy('date', 'asc')
            ->get();

        $balance = 0;
        foreach ($transactions as $trx) {
            $balance += $trx->credit - $trx->debit;
            $trx->balance = $balance;
            $trx->save();
        }

        $transaction->delete();
    }
}

