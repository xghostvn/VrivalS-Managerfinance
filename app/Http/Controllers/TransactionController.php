<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Wallets;
use App\Transactions;



class TransactionController extends Controller
{
    //
    public function index()
    {
        $wallet = new Wallets();
        return view("wallets.transfer",["wallets"=>$wallet->getUsersHasWallet()]);
    }
    public function updateTransaction(Request $request)
    {
            $validation = Validator::make($request->all(),[
                "money" => ["required", "numeric", "min:1000", "max:100000000"],
                "users" => ["required"]
            ]);
             $wallet1 = new Wallets();
            $money = $request->input("money");
            $idUserReceive = $request->input("users");
            if($wallet1->getWallet(Auth::id())->money < $money) {

                $validation->errors()->add("errors", "Not enough money");
            }
            if($validation->errors()->any()) {
                return redirect("transfer")->withErrors($validation);
            } else {
                $userReceive = new User();
                $walletReceive = new Wallets();
                $walletReceive->updateWallet($money, $userReceive->getUsers($idUserReceive)->id);
                $wallet1->updateWallet(-$money, Auth::id());
                $transaction = new Transactions();
                $transaction->createTransaction("Revenue",
                    $money,"From ".Auth::user()->name,
                    $walletReceive->getWallet($idUserReceive)->id);
                $transaction->createTransaction("Expenses",
                    $money, "To ".$userReceive->getUsers($idUserReceive)->name,
                    $wallet1->getWallet(Auth::id())->id);
                return redirect("transfer")->with("status", "Transfer Successful . ");
            }
    }

    public function moreExpenses(Request $request)
    {
            return view("wallets.expenses");
    }
    public function updateExpenses(Request $request)
    {
            $validation = Validator::make($request->all(),[
                "money" => ["required", "numeric", "min:1000", "max:100000000"],
                "description" => ["required", "string"]
            ]);
        $money = $request->input("money");
        $wallet = new Wallets();
        if($wallet->getWallet(Auth::id())->money < $money) {

            $validation->errors()->add("errors", "Not enough money");
        }
        if($validation->errors()->any()) {
            return redirect("transfer.moreExpenses")->withErrors($validation);
        }
        else {
            $description = $request->input("description");
            $transactions = new Transactions();
            $transactions
                ->createTransaction("Expenses",
                    $money, $description,
                    $wallet->getWallet(Auth::id())->id);
            $wallet->updateWallet(-$money,Auth::id());
            return redirect("transfer.moreExpenses")->with("status", "Expenses Successful . ");
        }
    }


    public function moreRevenue(Request $request)
    {
        return view("wallets.revenue");
    }

    public function updateRevenue(Request $request)
    {
        $wallet = new Wallets();
        $validation = Validator::make($request->all(),[
            "money" => ["required", "numeric", "min:1000", "max:100000000"],
            "description" => ["required", "string"]
        ]);
        $maxMoney = 100000000;
        $money = $request->input("money");
        if($money > 100000000) {

            $validation->errors()->add("errors",
                "The money may not be greater than ".helperController::formatMoney($maxMoney));
        }
        if($validation->errors()->any()) {
            return redirect("transfer.moreRevenue")->withErrors($validation);
        } else {

            $description = $request->input("description");
            $transactions = new Transactions();
            $transactions
                ->createTransaction("Revenue",
                    $money, $description,
                    $wallet->getWallet(Auth::id())->id);
            $wallet->updateWallet($money,Auth::id());
            return redirect("transfer.moreRevenue")->with("status", "Revenue Successful . ");
        }
    }
}
