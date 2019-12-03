<?php

namespace App\Http\Controllers;

use App\Exports\TransactionAllExport;
use App\Exports\TransactionExport;
use App\Transactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Wallets;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\WalletsRepositoryEloquent;


class WalletController extends Controller
{

    protected $repository;

    public function __construct(WalletsRepositoryEloquent $walletsRepositoryEloquent)
    {
        $this->repository = $walletsRepositoryEloquent;
        
    }

    public function index(Request $request)
    {
        $type = $request->type;
        $wallet = new Wallets();
        $transactions = new Transactions();
        if ($wallet->getWallet(Auth::id())) {
            helperController::createSessionExport("all",
                $wallet->getWallet(Auth::id())->id, null, null);
            if ($type == "date") {
                $transaction = $transactions
                    ->getTransactionDateTime($wallet->getWallet(Auth::id())->id,
                        session("to"),
                        session("from"), 3);
            } else {
                $transaction = $transactions
                    ->getTransaction($wallet->getWallet(Auth::id())->id, $type, 3);
            }

        } else {
            $wallet->create = true;
            return view("wallets.wallet", ["create" => $wallet->create]);
        }
        return view("wallets.wallet", [
            "create" => $wallet->create,
            "money" => helperController::formatMoney($wallet->getWallet(Auth::id())->money),
            "transactions" => $transaction
        ]);
    }

    public function createWallet()
    {
        $wallet = new Wallets();
        if ($wallet->createWallet()) {
            return redirect("wallet")->with("status", "cannot create wallet!");
        } else
            return redirect("wallet")->with("status", "create wallet successful !");
    }

    public function deleteWallet(Request $request)
    {

        $wallet = new Wallets();
//        $transaction = new Transactions();
//       $transaction->deleteTransaction($wallet->getWallet(Auth::id())->id);
        $wallet->deleteWallet(Auth::id());
        $request->session()->flash("status", "Delete Wallet successful !");
        $wallet->create = true;
        $a=1;
        return view("wallets.wallet", compact('a'));
    }

    public function getTransactionDateTime(Request $request)
    {
        if ($request->from != null && $request->To != null) {
            session()->put("from", $request->from);
            session()->put("to", $request->To);

        }
        return redirect("wallet/date");

    }

    public function export()
    {
        $date = date("Y-m-d");
        return Excel::download(new TransactionExport(), $date . ".xlsx");
    }


    public function data(Request $request)
    {

        $wallet = new Wallets();
        $transactions = new Transactions();
        $type = $request->type;
        helperController::createSessionExport($type,
            $wallet->getWallet(Auth::id())->id,
            $request->to,
            $request->from);
        if ($type == "date") {
            $transaction = $transactions
                ->getTransactionDateTime($wallet->getWallet(Auth::id())->id,
                    session("to"), session("from"), 3);
        } else {
            $transaction = $transactions
                ->getTransaction($wallet->getWallet(Auth::id())->id, $type, 3);
        }
        return view("wallets.a", [
            "transactions" => $transaction
        ]);
    }


}
