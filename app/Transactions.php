<?php

namespace App;

use App\Http\Controllers\helperController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transactions extends Model
{
    //
    protected $table = "transactions";


    public function getTransaction($walletID, $type, $paginate)
    {
        if($type==null) {
            return Transactions::where('wallet_id', $walletID)->paginate($paginate);
        } else {
            return Transactions::where('wallet_id', $walletID)
                ->where('type', $type)
                ->paginate($paginate);
        }
    }

    public function createTransaction($type, $money, $description, $walletID)
    {
        $transfer = new Transactions;
        $transfer->type = $type;
        $transfer->amount =$money;
        $transfer->description  = $description;
        $transfer->wallet_id = $walletID;
        return $transfer->save();
    }


    public function deleteTransaction($walletID)
    {
        $transaction = Transactions::where('wallet_id', $walletID);
        return $transaction->delete();
    }

  public function getTransactionDateTime($walletID, $to, $from, $paginate)
  {
        $to = helperController::formatDate($to);
        $transactions = Transactions::where('wallet_id', $walletID)
            ->where('created_at', '<=', $to)
            ->where('created_at', '>=', $from)
            ->paginate($paginate);
        return $transactions;
  }





}
