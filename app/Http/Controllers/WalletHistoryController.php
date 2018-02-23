<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActiveDo;
use App\ActiveSdo;
use App\Bonus;
use App\BonusType;
use App\Referral;
use App\Wallet;
use App\WalletHistory;

use Carbon\Carbon;

class WalletHistoryController extends Controller
{
    public function backupWalletDetails()
    {
    	$date = Carbon::today();
        $this_year = $date->year;
        $this_month = $date->month;

        if($this_month == 1){
            $this_month = 12;
            $this_year  = $this_year - 1;
        } else {
            $this_month = $this_month - 1;
        }
        
    	$wallets = Wallet::all();

    	foreach ($wallets as $wallet) 
    	{
    		$wallet_history = new WalletHistory;
    		$wallet_history->user_id 				= $wallet->user_id;
    		$wallet_history->rank_id 				= $wallet->user->rank_id;
    		$wallet_history->p_wallet				= $wallet->p_wallet;
    		$wallet_history->rmvp    				= $wallet->rmvp;
    		$wallet_history->pv      				= $wallet->pv;
    		$wallet_history->rmvp_first_purchased 	= $wallet->first_purchased_rmvp;
    		$wallet_history->pv_first_purchased 	= $wallet->first_purchased;
    		$wallet_history->month	 				= $this_month;
    		$wallet_history->year 	 				= $this_year;
    		$wallet_history->save();
    	}
    }

    public function bonusStatementDetails()
    {
    	//
    }

    
}
