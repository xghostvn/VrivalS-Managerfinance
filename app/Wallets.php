<?php

namespace App;

use App\Http\Controllers\TransactionController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Wallets extends Model
{
    //
    protected $table = "wallets";
    public $create = false;

    public function transaction()
    {
        return $this->hasMany('App\Transactions','wallet_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function getUsersHasWallet()
    {
        $wallets = Wallets::with('user')->get();
        return $wallets;
    }

    public function getWallet($userID)
    {
            if($userID==null) {
                return Wallets::all();
            } else {
                return Wallets::where('user_id',$userID)->first();
            }
    }

    public function createWallet()
    {
        $wallet = new Wallets;
        $wallet->user_id = Auth::id();
        $wallet->money = 10000000;
       return $wallet->save();
    }

    public function deleteWallet($userID)
    {
       return  Wallets::where('user_id',$userID)->delete();
    }

    public function updateWallet($money, $userID){
        $wallet = Wallets::where('user_id',$userID)->first();
        $wallet->money += $money;
        return $wallet->save();
    }
















}
