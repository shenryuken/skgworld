<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Wallet;
use App\ActiveDo;
use App\UserBonus;

use Validator;
use Session;

class WalletController extends Controller
{
    public function mywallet()
    {
		$user     = Auth::user();
		$wallet   = $user->wallet;

		$user_bonus	= UserBonus::where('user_id',$user->id)->first();
		$active_do 	= ActiveDo::where('user_id', $user->id)->first();

		$qualified_bonus = [
			'retail_profit' => 'no',
			'personal_rebate' => 'no',
			'direct_sponsor'  => 'no',
			'do_group_bonus'  => 'no',
			'do_cto' 		  => 'no',
			'sdo_cto'         => 'no',
			'sdo'             => 'no',
			'sdo_to_sdo'      => 'no'
		];

		if($user->rank_id == 2 && ($wallet && $wallet->pv >= 100))
		{
			$qualified_bonus['personal_rebate'] = 'yes';
		}
		elseif ($user->rank_id == 3 && ($wallet && $wallet->pv >= 100))
		{
			$qualified_bonus['retail_profit'] = 'yes';
			$qualified_bonus['personal_rebate'] = 'yes';
			$qualified_bonus['direct_sponsor']  = 'yes';
		}
		elseif($user->rank_id == 4 && ($wallet && $wallet->pv >= 100))
		{
			$qualified_bonus['retail_profit'] = 'yes';
			$qualified_bonus['personal_rebate'] = 'yes';
			$qualified_bonus['direct_sponsor']  = 'yes';
			$qualified_bonus['do_group_bonus']  = 'yes';

			if($active_do && $active_do->personal_gpv >= 4000) $qualified_bonus['do_cto'] = 'yes';
			
		}
		elseif($user->rank_id == 5 && ($wallet && $wallet->pv >= 100))
		{
			$qualified_bonus['retail_profit'] = 'yes';
			$qualified_bonus['personal_rebate'] = 'yes';
			$qualified_bonus['direct_sponsor']  = 'yes';
			$qualified_bonus['do_group_bonus']  = 'yes';

			if($active_do && $active_do->personal_gpv >= 5000) $qualified_bonus['do_cto'] = 'yes';

			$qualified_bonus['sdo_cto'] 		  = 'yes'; //need to clarify again - group branch 5k or ???
			$qualified_bonus['sdo']             = 'yes';
			$qualified_bonus['sdo_to_sdo']      = 'yes';
		}
		
		//print_r($id);
    	return view('wallets.mywallet', compact('wallet', 'qualified_bonus', 'user_bonus'));
    }
}
