<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActiveDo;
use App\ActiveSdo;
use App\Bonus;
use App\BonusType;
use App\Referral;
use App\Voucher;
use App\User;
use App\Rank;
use App\Wallet;
use App\UserPurchase;
use App\Store;
use App\Product;
use App\Sale;
use App\SdoLicense;
use App\SdoMerit;

use Validator;
use Session;
use DateTime;
use DB;

class BonusControllerV2 extends Controller
{
    public function index()
    {
        return view('bonus.index');
    }

    public function history()
    {
        $bonuses = Bonus::all();

        return view('bonus.history', compact('bonuses'));
    }

    public function my_bonus_history($user_id)
    {
        $my_bonuses = Bonus::where('user_id', $user_id)->get();

        return view('bonus.my_history', compact('my_bonuses'));
    }

    public function summary($user_id)
    {
        $personal_rebates = Bonus::where('user_id', $user_id)->whereBetween('bonus_type_id',[1,4] )->get();
        $direct_sponsors  = Bonus::where('user_id', $user_id)->whereBetween('bonus_type_id',[5,7] )->get();
        $do_group_bonuses = Bonus::where('user_id', $user_id)->where('bonus_type_id', '=', 8 )->get();

        return view('bonus.summary', compact('personal_rebates', 'direct_sponsors', 'do_group_bonuses'));
    }

    //for admin only
    public function showBonusSummary($user_id)
    {
        $bonus = Wallet::where('user_id', $user_id)->first();

        return view('bonus.show-bonus-summary', compact('bonus'));

    }

    //Bonus Type
    public function bonusType()
    {
    	$bonus_types = BonusType::all();

    	return view('bonus.bonus-types', compact('bonus_types'));
    }

    public function addBonusType()
    {
    	$ranks = Rank::all();

    	return view('bonus.add-bonus-type', compact('ranks'));
    }

    public function editBonusType($id)
    {
        $bonus_type = BonusType::find($id);

        return view('bonus.edit-bonus-type', compact('bonus_type'));
    }

    public function updateBonusType(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'value'     => 'required',
            'value_type'=> 'required',
            'rank'      => 'required',
            'term'      => 'required',
            'duration'  => 'required',
            'duration_type' => 'required',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        } else {

            $bonus_type = BonusType::find($id);
            $bonus_type->name   = $request->name;
            $bonus_type->value  = $request->value;
            $bonus_type->value_type     = $request->value_type;
            $bonus_type->rank   = $request->rank;
            $bonus_type->term   = $request->term;
            $bonus_type->duration       = $request->duration;
            $bonus_type->duration_type  = $request->duration_type;
            $bonus_type->description    = $request->description;
            $bonus_type->save();

            return redirect('bonus/bonus-types');
        }
    }
    //End Bonus Type

    //Calculate Bonus
    public function calculateMonthlyBonus()
    {
        $this->calculateMonthlySales();

        $userPurchases = $this->getUserPurchases();
        $this->retailProfitsForAgents();
    }
    //End Calculate Bonus
    
    //Calculate Monthly Sales Price & PV
    public function calculateMonthlySales()
    {
    	$total_sales_price1   = UserPurchase::sum('price');
        $total_sales_price2   = Store::sum('price');
        $grand_total_sales_price    = $total_sales_price1 + $total_sales_price2;

        $total_sales_pv1      = UserPurchase::sum('pv');
        $total_sales_pv2      = Store::sum('pv');
        $grand_total_pv       = $total_sales_pv1 + $total_sales_pv2;

        $year = Carbon::now()->year;
        $month = Carbon::mow()->month;

        if($month == 1) { $month = 12; $year = $year - 1; } 
        else { $month = $month - 1; }

        $sale   = Sale::where('year', $year)->where('month', $month)->first();
        $sale->total_sale = $total_sales;
        $sale->total_pv   = $total_pv;
        $sale->save();
    }
    //End Calculate Monthly Sales Price & PV

    //Calculate Retail Profits For All Agents
    public function retailProfitsForAgents()
    {
    	
    	$rank = $this->getUserRankId();
    }

    public function overrideRetailProfitsForAgents()
    {

    }

    public function getUserPurchases()
    {
    	$allPurchases 		= collect(); 
    	//get from customer purchases
    	$customerPurchases	= UserPurchase::groupBy('user_id', 'product_id')
                            ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')->get();
    	//get from agent stores 
        $agentPurchases    	= Store::groupBy('user_id', 'product_id')
                            ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')->get();
                            
        foreach($customerPurchases as $customerPurchase)
        	$allPurchases->push($customerPurchase);

        foreach($agentPurchases as $agentPurchase)
        	$allPurchases->push($agentPurchases);

        return $allPurchases;
    }
    //End Calculate Retail Profits For All Agents
}
