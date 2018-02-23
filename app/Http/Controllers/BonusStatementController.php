<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
Use App\Bonus;
use App\BonusType;
use App\Referral;
use App\Wallet;
use App\BonusStatement;

class BonusStatementController extends Controller
{
    public function getBonusStatement($user_id)
    {
    	$root = User::where('user_id', $user_id)->first();

    	$referrals 		= array();
    	$descendants  	= $root->getDescendants();

    	$bonus = [
    				'user_id'                   => $user_id,
    				'retail_profit' 			=> $retail_profit,
    				'override_retail_profit' 	=> $override_retail_profit,
    				'personal_rebate' 			=> $personal_rebate,
    				'override_personal_rebate'  => $override_personal_rebate,
     				'direct_sponsor' 			=> $direct_sponsor,
    				'indirect_sponsor'	 		=> $indirect_sponsor,
    				'do_group_bonus'            => $do_group_bonus,
    				'do_cto_pool'				=> $do_cto_pool,
    				'sdo_cto_pool'				=> $sdo_cto_pool,
    				'sdo_bonus'					=> $sdo_bonus,
    				'sdo_to_sdo_bonus'          => $sdo_to_sdo_bonus,
    				];

    	$statements = array();

    	foreach ($descendants as $descendant) {
    		$wallet = Wallet::where('user_id', $descendant->user_id)->first();

    		if($wallet && ($wallet->pv > 0 || $wallet->first_purchased > 0))
    		{
    			$referrals[] = $descendant->toArray();
    		}
    	}
    }

    public function getRetailProfit($root, $referral)
    {
    	$referral_rank = $this->getUserRankId($referral->user_id);
    	$wallet = Wallet::where('user_id', $referral->user_id)->first();

    	if($user_rank > 2)
    	{
    		$retail_profit = number_format(0.15, 2) * $wallet->rmvp;
    	}
    	else 
    	{
    		$retail_profit = number_format(0.05, 2) * ($wallet->rmvp - $wallet->first_purchased_rmvp);
    	}
    }

    public function getOverrideRetailProfit()
    {
    	//
    }

    public function getPersonalRebate()
    {
    	//
    }

    public function getOverridePersonalRebate()
    {
    	//
    }

    public function getDirectSpondsor($root, $referral)
    {
    	$referral_rank = $this->getUserRankId($referral->user_id);
    	$root_rank     = $this->getUserRankId($referral->user_id);

    	$wallet = Wallet::where('user_id', $referral->user_id)->first();

    	if( $referral_rank > $root_rank)
    	{
    		$first_bonus  = number_format(0.3, 2) * $wallet->first_purchased;
    		$second_bonus = number_format(0.10, 2) * ($wallet->pv - $wallet->first_purchased);

    		$direct_sponsor_bonus = $first_bonus + $second_bonus;
    	} 
    	else 
    	{
    		$first_bonus  = number_format(0.5, 2) * $wallet->first_purchased;
    		$second_bonus = number_format(0.2, 2) * ($wallet->pv - $wallet->first_purchased);

    		$direct_sponsor_bonus = $first_bonus + $second_bonus;
    	}

    	return $direct_sponsor;

    }

    public function getIndirectSponsor()
    {
    	//
    }

    public function getDoGroupBonus()
    {
    	//
    }

    public function getDoCtoPool()
    {
    	//
    }

    public function getSdoCtoPool()
    {
    	//
    }

    public function getSdoBonus()
    {
    	//
    }

    public function getSdoToSdoBonus()
    {
    	//
    }

    public function getUserRankId($id) //get rank id
    {
        //return ( $id = 0 || $id = 'null') ? 'null' : $rank_id = User::find($id)->rank_id;
        $user = User::find($id);
        $rank = $user != null ? $user->rank_id: 0;

        return $rank;
    }
}
