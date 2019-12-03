<?php

namespace App\Exports;

use App\Http\Controllers\helperController;
use App\Http\Controllers\TransactionController;
use App\Transactions;
use App\Wallets;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $wallet = new Wallets();
        $id = $wallet->getWallet(Auth::id())->id;
         if(session('export')== 'Revenue') {
            return Transactions::where('wallet_id', $id)
                ->where('type', "Revenue")
                ->get();
        } else if(session('export') == 'Expenses') {
            return Transactions::where('wallet_id', $id)
                ->where('type', "Expenses")
                ->get();
        } else if(session('export') == 'date') {
            $to = helperController::formatDate(session('to'));
            $from = session('from');
            return Transactions::where('wallet_id', $id)
                ->where('created_at', '<=', $to)
                ->where('created_at', '>=', $from)
                ->get();
        } else {
            return Transactions::where('wallet_id', $id)->get();
        }

    }


    public function headings(): array {
        return [
            'ID',
            'Amount',
            "Created",
        ];
    }

    public function map($transaction): array {
        return [
            $transaction->id,
            $transaction->amount,
            $transaction->created_at,

        ];
    }


}
