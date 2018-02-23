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
use App\UserBonus;

use Carbon\Carbon;

use Validator;
use Session;
use DateTime;
use DB;

class BonusController extends Controller
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

        return view('bonus.my-history', compact('my_bonuses'));
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
    public function calculate_end_month_bonus()
    {
        $year   = (new DateTime)->format("Y");
        $month  = (new DateTime)->format("n");
        if($month == 1){
            $month = 12;
            $year  = $year - 1;
        } else {
            $month = $month - 1;
        }

        //count for DO Rank Members
        $do_members     = ActiveDo::all();
        $sdo_members    = ActiveSdo::all();
        //$userPurchases  = UserPurchase::all();  // originall
        $userPurchases  = UserPurchase::groupBy('user_id', 'product_id')
                            ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->get();
        //$userStores     = Store::all(); // originall
        $userStores     = Store::groupBy('user_id', 'product_id')
                            ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->get();
        
        $next_do_members= $do_members;
        $i              = 0;
        $n              = count($do_members);

        $total_sales1   = UserPurchase::sum('price');
        $total_sales2   = Store::sum('price');
        $total_sales    = $total_sales1 + $total_sales2;

        $total_pv1      = UserPurchase::sum('pv');
        $total_pv2      = Store::sum('pv');
        $total_pv       = $total_pv1 + $total_pv2;

        $sale   = Sale::where('year', $year)->where('month', $month)->first();
        $sale->re_total_sale = $total_sales;
        $sale->re_total_pv   = $total_pv;
        $sale->save();

        // echo '<br>';
        // echo '<pre>';
        // print_r($userStores);
        // echo '<pre>';
        // echo '<br>';

        foreach ($userPurchases as $userPurchase) 
        {
            $this->retail_price($userPurchase->user_id, $userPurchase->price, $userPurchase->product_id);
            //$this->upline_personal_rebate($userPurchase->user_id, $userPurchase->pv);
            $this->personal_rebate($userPurchase->user_id, $userPurchase->pv, $userPurchase->product_id);
        }

        foreach($userStores as $store)
        {
            $this->retail_price($store->user_id, $store->price, $store->product_id);
            //$this->pay_valid_upline_for_personal_rebate($store->user_id, $store->pv);
            //$this->upline_personal_rebate($store->user_id, $store->pv);
            $this->personal_rebate($store->user_id, $store->pv, $store->product_id);
        }

        foreach($do_members as $member)
        {
            $this->calculate_active_do_personal_gpv($member->user_id);
            // $this->group_bonus($member->user_id);
        }

        foreach($do_members as $member)
        {
            // $this->calculate_active_do_personal_gpv($member->user_id);
             $this->group_bonus($member->user_id);
        }

        $this->calculate_total_group_pv();

        foreach ($sdo_members as $smember) {
            $this->calculate_active_sdo_personal_gpv($smember->user_id);
            // $this->sdo_bonus($smember->user_id);  //need to separate
            // $this->sdo_to_sdo_bonus($smember->user_id); //need to separate
        }

        foreach ($sdo_members as $smember) {
            $this->sdo_bonus($smember->user_id);  
            $this->sdo_to_sdo_bonus($smember->user_id); 
        }

        // foreach($next_do_members as $next_member)
        // {
        //     //$this->calculate_active_do_personal_gpv($member->user_id);
        //     $this->group_bonus($next_member->user_id);
        // }

        $ewallets = Wallet::all();

        foreach ($ewallets as $wallet) {
            //$this->direct_sponsor_bonus($wallet->user_id, $wallet->pv, $wallet->first_purchased);
            $this->direct_sponsor_bonus($wallet->user_id, $wallet->pv);
        }

        $do_cto_bonus  = $this->do_cto_bonus();
        $sdo_cto_bonus = $this->sdo_cto_bonus();

        //$this->countTotalBonus();
        $this->recordUserBonuses();
        //$this->countTotalBonus();
    }
    //End Calculate Bonus

    //Retai Price Bonus
    //Qualified Rank MO/DO/SDO - 20% from market price
    public function retail_price($id, $total_price, $product_id)
    {
       $rank   = $this->getUserRankId($id);
       $wallet = Wallet::where('user_id', $id)->first();
       $data   = [
                    'user_id'     => $id,
                    'rank'        => $rank,
                    'total_price' => $total_price,
                    'product_id'  => $product_id, 
                    'from_user_id'=> $id,
                 ];

       if($rank == 1)
        {
            $upline = $this->getUpline($id);
            
            if(!is_null($upline))
            {
                $upline_rank = $this->getUserRankId($upline->user_id);

                $data   = [
                    'user_id'     => $upline->user_id,
                    'rank'        => $upline_rank,
                    'total_price' => $total_price,
                    'product_id'  => $product_id, 
                    'from_user_id'=> $id,
                    'bonus'       => 0.20
                 ];

                $this->override_retail_price($data);
            }
            
        } 
        elseif($rank == 2)
        {
            if($wallet && $wallet->purchased >= 2)
            {
                $wallet->retail_profit = $wallet->retail_profit +(number_format(0.05, 2) * $total_price);
                $wallet->save();

                $bonus = new Bonus;
                $bonus->user_id = $id; 
                $bonus->amount  = number_format(0.05, 2) * $total_price;
                $bonus->bonus_type_id = 1;
                $bonus->description   = 'Personal Retail Profit';
                $bonus->from_user_id  = $id;
                $bonus->save();

                // $data['bonus'] = 0.15;
                // $this->override_retail_price($data);

                $upline = $this->getUpline($id);
            
                if(!is_null($upline))
                {
                    $upline_rank = $this->getUserRankId($upline->user_id);
                    
                    $data   = [
                        'user_id'     => $upline->user_id,
                        'rank'        => $upline_rank,
                        'total_price' => $total_price,
                        'product_id'  => $product_id, 
                        'from_user_id'=> $id,
                        'bonus'       => 0.15
                     ];
                    $this->override_retail_price($data);
                }
            }
            else
            {
                $upline = $this->getUpline($id);
            
                if(!is_null($upline))
                {
                    $upline_rank = $this->getUserRankId($upline->user_id);
                    
                    $data   = [
                        'user_id'     => $upline->user_id,
                        'rank'        => $upline_rank,
                        'total_price' => $total_price,
                        'product_id'  => $product_id, 
                        'from_user_id'=> $id,
                        'bonus'       => 0.20
                     ];
                    $this->override_retail_price($data);
                }
            }
        }
        elseif($rank >= 3)
        {   
            $wallet = Wallet::where('user_id', $id)->first();
            if(!is_null($wallet))
            {
                $wallet->retail_profit = $wallet->retail_profit +(number_format(0.20, 2) * $total_price);
                $wallet->save();

                $bonus = new Bonus;
                $bonus->user_id = $id; 
                $bonus->amount  = number_format(0.20, 2) * $total_price;
                $bonus->bonus_type_id = 1;
                $bonus->description   = 'Personal Retail Profit';
                $bonus->from_user_id  = $id;
                $bonus->save();
            }
            else
            {
                $upline = $this->getUpline($id);
            
                if(!is_null($upline))
                {
                    $upline_rank = $this->getUserRankId($upline->user_id);
                    
                    $data   = [
                        'user_id'     => $upline->user_id,
                        'rank'        => $upline_rank,
                        'total_price' => $total_price,
                        'product_id'  => $product_id, 
                        'from_user_id'=> $id,
                        'bonus'       => 0.20
                     ];
                    $this->override_retail_price($data);
                }
            } 
        }
    }

    public function override_retail_price($data)
    {
        if($data['bonus'] == 0.20)
        {
            if($data['rank'] >= 3)
            {
                $wallet = Wallet::where('user_id', $data['user_id'])->first();
                if(!is_null($wallet))
                {
                    $wallet->retail_profit = $wallet->retail_profit +(number_format($data['bonus'], 2) * $data['total_price']);
                    $wallet->save();

                    $bonus = new Bonus;
                    $bonus->user_id = $data['user_id']; 
                    $bonus->amount  = number_format($data['bonus'], 2) * $data['total_price'];
                    $bonus->bonus_type_id = 2;
                    $bonus->description   = 'Override Retail Price';
                    $bonus->from_user_id  = $data['from_user_id'];
                    $bonus->save();
                }   
            }
            elseif($data['rank'] == 2)
            {
                $wallet = Wallet::where('user_id', $data['user_id'])->first();

                if(!is_null($wallet))
                {
                    $wallet->retail_profit = $wallet->retail_profit +(number_format(0.05, 2) * $data['total_price']);
                    $wallet->save();

                    $bonus = new Bonus;
                    $bonus->user_id = $data['user_id']; 
                    $bonus->amount  = number_format(0.05, 2) * $data['total_price'];
                    $bonus->bonus_type_id = 2;
                    $bonus->description   = 'Override Retail Price';
                    $bonus->from_user_id  = $data['from_user_id'];
                    $bonus->save();
                }   

                $upline         = $this->getUpline($data['user_id']);

                if(!is_null($upline))
                {
                    $upline_rank    = $this->getUserRankId($upline->user_id);
                    $data = [
                            'user_id'     => $upline->user_id,
                            'rank'        => $upline_rank,
                            'total_price' => $data['total_price'],
                            'product_id'  => $data['product_id'],   
                            'from_user_id'=> $data['from_user_id'],
                            'bonus'       => 0.15
                        ];

                    $this->override_retail_price($data);
                }
                
            }
            else
            {
                $upline         = $this->getUpline($data['user_id']);
                if(!is_null($upline))
                {
                    $upline_rank    = $this->getUserRankId($upline->user_id);
                    $data = [
                            'user_id'     => $upline->user_id,
                            'rank'        => $upline_rank,
                            'total_price' => $data['total_price'],
                            'product_id'  => $data['product_id'],  
                            'from_user_id'=> $data['from_user_id'],
                            'bonus'       => 0.20
                        ];

                    $this->override_retail_price($data);
                }
                
            }
        }
        elseif($data['bonus'] == 0.15)
        {
            if($data['rank'] >= 3)
            {
                $wallet = Wallet::where('user_id', $data['user_id'])->first();
                if(!is_null($wallet))
                {
                    $wallet->retail_profit = $wallet->retail_profit +(number_format(0.15, 2) * $data['total_price']);
                    $wallet->save();

                    $bonus = new Bonus;
                    $bonus->user_id = $data['user_id']; 
                    $bonus->amount  = number_format(0.15, 2) * $data['total_price'];
                    $bonus->bonus_type_id = 2;
                    $bonus->description   = 'Override Retail Price';
                    $bonus->from_user_id  = $data['from_user_id'];
                    $bonus->save();
                }   
            }
            else
            {
                $upline         = $this->getUpline($data['user_id']);
                if(!is_null($upline))
                {
                    $upline_rank    = $this->getUserRankId($upline->user_id);
                    $data = [
                            'user_id'     => $upline->user_id,
                            'rank'        => $upline_rank,
                            'total_price' => $data['total_price'],
                            'product_id'  => $data['product_id'],  
                            'from_user_id'=> $data['from_user_id'],
                            'bonus'       => 0.15
                        ];

                    $this->override_retail_price($data);
                }
                
            }
        }
    }
   
    //Personal Rebate for Loyal Customer And Above
    //Count for self and upline
    public function personal_rebate($id, $pv, $product_id)
    {
        // $x = 3;
        // $last_highest_rank = 1;
        $user = User::find($id);

        $user_rank = $user->rank_id;//$this->getUserRankId($id);
        
        if($user_rank >= 3)
        {
            // $prsnl_rebate  = $this->getPersonalRebate($id);
            $evoucher      = number_format(0.2, 2) * $pv;
            $product       = Product::find($product_id);

            $wallet = Wallet::firstOrNew(['user_id'  => $id] );

            if( $wallet && $wallet->pv >= 100)
            {
                //$wallet->evoucher = $wallet->evoucher + $evoucher;
                $wallet->personal_rebate = $wallet->personal_rebate + $evoucher;
                $wallet->save();

                $bonus = new Bonus;
                $bonus->user_id         = $id;
                $bonus->bonus_type_id   = 3;
                $bonus->amount          = $evoucher;
                $bonus->description     = "Personal Rebate Purchase For Product: ".$product->name." Bonus: ". $evoucher ."%";
                $bonus->from_user_id    = $id;
                $bonus->save();
            }

        }
        else
        {
            $this->upline_personal_rebate($id, $pv);
        }      
    }

    //Original code for personal rebate - count only for upline
    public function upline_personal_rebate($id, $pv)
    {
        $x = 1;
        //$last_highest_rank =  1;
        $downline = User::find($id);
        
        while($x > 0)
        {
            $evoucher       = 0;
            $parent         = $this->getUpline($id);
            $user_rank      = $this->getUserRankId($id);
            $parent_rank    = $this->getUserRankId(is_null($parent) ? 0 : $parent->user_id );
            //$last_rebate    = $this->getPersonalRebate($id);

            // echo 'id = '. $id;
            // echo 'parent_rank ='.$parent_rank.'<br/>';
            // echo 'user_rank ='.$user_rank.'<br/>';

            if(is_null($parent)){
                break;
            } else {
                if($parent_rank < 3)
                {
                    $id     = $parent->id;
                }
                elseif($parent_rank >= 3)
                {
                    // $parent_rebate      = $this->getPersonalRebate($parent->user_id);
                    // $balance_rebate     = $parent_rebate - $last_rebate;

                    $evoucher   = (0.20) * $pv;

                    $wallet = Wallet::firstOrNew(['user_id'  => $parent->user_id] );

                    if( $wallet->pv >= 100){
                        //$wallet->evoucher = $wallet->evoucher + $evoucher;
                        $wallet->personal_rebate = $wallet->personal_rebate + $evoucher;
                        $wallet->save();

                        $bonus = new Bonus;
                        $bonus->user_id         = $parent->user_id;
                        $bonus->bonus_type_id   = 4;
                        $bonus->amount          = $evoucher;
                        $bonus->description     = "Override PR Downline Purchase ".$downline->username . " Override Bonus: ". 20 ."%";
                        $bonus->from_user_id    = $downline->id;
                        $bonus->save();
                    }

                    $id     = $parent->id;

                    // $last_highest_rank = $parent_rank;
                    // $last_rebate       = $parent_rebate;

                    $x = 0;

                    // echo 'Parent = ' .$parent .'<br/>';
                    // echo '= Evoucher = ' .$evoucher .' <br/>';
                    // echo 'last_highest_rank = '. $last_highest_rank .'<br/>';
                }
            } 
        }
    }
    
    public function direct_sponsor_bonus($user_id, $pv)
    {
        $node           = Referral::where('user_id', $user_id)->first();
        $node_rank      = $this->getUserRankId($user_id);
        $node_wallet    = Wallet::where('user_id', $user_id)->first();
        $first_pv       = $node_wallet->first_purchased;
        $second_pv      = $node_wallet->pv - $first_pv ; 

        $parent         = $this->getUpline($user_id);
        // $parent_rank    = $this->getUserRankId(is_null($parent) ? 0 : $parent->user_id );
        // $parent_wallet  = Wallet::where('user_id', $parent->user_id)->first();

        //if($node_rank > 2 && ($node_rank <= $parent_rank) )
        if(!is_null($parent) )
        {

            $parent_rank    = $this->getUserRankId(is_null($parent) ? 0 : $parent->user_id );
            $parent_wallet  = Wallet::where('user_id', $parent->user_id)->first();
            
            if($parent_rank > 2 && ($node_rank <= $parent_rank) )
            {
                // $bonus          = number_format(0.5, 2);
                $first_bonus        = $first_pv * number_format(0.5, 2);
                $second_bonus       = $second_pv * number_format(0.2, 2);

                if($parent_wallet && $parent_wallet->pv >= 100)
                {
                    $parent_wallet->direct_sponsor = $parent_wallet->direct_sponsor + ($first_bonus + $second_bonus); 
                    $parent_wallet->save();

                    $bonus = new Bonus;
                    $bonus->user_id         = $parent->user_id;
                    $bonus->bonus_type_id   = 5;
                    $bonus->amount          = $first_bonus + $second_bonus;
                    $bonus->description     = "Direct Sponsor";
                    $bonus->from_user_id    = $user_id;
                    $bonus->save();
                } 
                else
                {
                    $id = $parent->user_id;
                    $x = 1;
                    while($x > 0)
                    {
                        $upline = $this->getUpline($id );
                        
                        if(!is_null($upline))
                        {   
                            $upline_rank    = $this->getUserRankId($upline->user_id);
                            $upline_wallet  = Wallet::where('user_id', $upline->user_id )->first();

                            if($upline_rank >= 3 && ($upline_wallet && $upline_wallet->pv >= 100))
                            {
                                $first_bonus        = $first_pv * number_format(0.5, 2);
                                $second_bonus       = $second_pv * number_format(0.2, 2);

                                $upline_wallet->direct_sponsor = $upline_wallet->direct_sponsor + ($first_bonus + $second_bonus);
                                $upline_wallet->save();

                                $bonus = new Bonus;
                                $bonus->user_id         = $upline->user_id;
                                $bonus->bonus_type_id   = 6;
                                $bonus->amount          = $first_bonus + $second_bonus;
                                $bonus->description     = "Indirect Sponsor";
                                $bonus->from_user_id    = $user_id;
                                $bonus->save();

                                $x = 0;
                            }
                            else
                            {
                                //$upline = $this->getUpline($upline->user_id);
                                //$id     = is_null($upline) ? 0:$upline->user_id;
                                $id = $upline->user_id;
                            }
                        } else {
                            break;
                        }
                    }
                }
            }
            //elseif($node_rank > 2 && ($node_rank > $parent_rank) )
            elseif($parent_rank > 2 && ($node_rank > $parent_rank) )
            {
                // $bonus          = number_format(0.5, 2);
                $first_bonus       = $first_pv * number_format(0.3, 2);
                $second_bonus      = $second_pv * number_format(0.1, 2);

                if($parent_wallet && $parent_wallet->pv >= 100)
                {
                    $parent_wallet->direct_sponsor = $parent_wallet->direct_sponsor + ($first_bonus + $second_bonus);
                    $parent_wallet->save();

                    $bonus = new Bonus;
                    $bonus->user_id         = $parent->user_id;
                    $bonus->bonus_type_id   = 5;
                    $bonus->amount          = $first_bonus + $second_bonus;
                    $bonus->description     = "Direct Sponsor";
                    $bonus->from_user_id    = $user_id;
                    $bonus->save();
                }

                // $balance_first_bonus  = number_format(0.2, 2);
                // $balance_second_bonus = number_format(0.1, 2);

                $id = $parent->user_id;
                $balance = 1;

                while($balance > 0)
                {
                    $upline = $this->getUpline($id );
                    if(!is_null($upline))
                    {
                        $upline_wallet = Wallet::where('user_id', $upline->user_id )->first();
                        $upline_rank   = $this->getUserRankId($upline->user_id);

                        if($upline_rank >= 4 && $upline_wallet && $upline_wallet->pv >= 100)
                        {
                            $first_bonus       = $first_pv * number_format(0.2, 2);
                            $second_bonus      = $second_pv * number_format(0.1, 2);

                            $upline_wallet->direct_sponsor = $upline_wallet->direct_sponsor + ($first_bonus + $second_bonus);
                            $upline_wallet->save();

                            $bonus = new Bonus;
                            $bonus->user_id         = $upline->user_id;
                            $bonus->bonus_type_id   = 6;
                            $bonus->amount          = $first_bonus + $second_bonus;
                            $bonus->description     = "Indirect Sponsor";
                            $bonus->from_user_id    = $user_id;
                            $bonus->save();

                            $balance = 0;
                        }
                        else
                        {
                            //$upline = $this->getUpline($upline->user_id);
                            //$id     = is_null($upline) ? 0:$upline->user_id;
                            $id = $upline->user_id;
                        }
                    } else {
                        break;
                    }

                }
            }
            elseif($parent_rank <= 2)
            {
                $id = $parent->user_id;
                $x = 1;
                while($x > 0)
                {
                    $upline         = $this->getUpline($id );
                    
                    if(!is_null($upline))
                    {   
                        $upline_rank    = $this->getUserRankId($upline->user_id);
                        $upline_wallet  = Wallet::where('user_id', $upline->user_id )->first();

                        if($upline_rank >= 3 && ($upline_wallet && $upline_wallet->pv >= 100))
                        {
                            $first_bonus        = $first_pv * number_format(0.5, 2);
                            $second_bonus       = $second_pv * number_format(0.2, 2);

                            $upline_wallet->direct_sponsor = $upline_wallet->direct_sponsor + ($first_bonus + $second_bonus);
                            $upline_wallet->save();

                            $bonus = new Bonus;
                            $bonus->user_id         = $upline ->user_id;
                            $bonus->bonus_type_id   = 6;
                            $bonus->amount          = $first_bonus + $second_bonus;
                            $bonus->description     = "Indirect Sponsor";
                            $bonus->from_user_id    = $user_id;
                            $bonus->save();

                            $x = 0;
                        }
                        else
                        {
                            //$upline = $this->getUpline($upline->user_id);
                            //$id     = is_null($upline) ? 0:$upline->user_id;
                            $id = $upline->user_id;
                        }
                    } else {
                        break;
                    }

                }
                
            }
        }
        
    }

    //Calculate Personal GPV with personal PV
    public function calculate_active_do_personal_gpv($user_id)
    {
        $root = Referral::where('user_id', $user_id)->first();
        $root_wallet = Wallet::where('user_id', $user_id)->first();
 
        $descendants = $root->getDescendants();
        $first_pv_purchased = 0;
        $personal_gpv = 0;
        $first_gpv_purchased = $root_wallet ? $root_wallet->first_purchased:0;
        $right        = 0;
        $qualified    = array();

        foreach ($descendants as $descendant)
        {
            $rank = $this->getUserRankId($descendant->user_id);

            if($rank < 4 && $descendant->rgt > $right)
            {
                $wallet = Wallet::where('user_id', $descendant->user_id)->first();

                $first_gpv_purchased = $first_gpv_purchased + ($wallet ? $wallet->first_purchased:0) ;
                $personal_gpv = $personal_gpv + ($wallet ? $wallet->pv:0);//without root personal pv
                $qualified[]  = $descendant->toArray();
            }
            elseif ($rank >= 4 )
            {
                if($right < $descendant->rgt)
                {
                    $right = $descendant->rgt;
                }
            }
        }

        $root_wallet = Wallet::where('user_id', $user_id)->first();//root personl pv

        $active_do = ActiveDo::where('user_id', $user_id)->first();
        $active_do->personal_gpv = $personal_gpv + ($root_wallet ? $root_wallet->pv:0);
        $active_do->first_gpv_purchased = $first_gpv_purchased;
        $active_do->save();

        // echo '<pre>';
        // print_r($qualified);
        // echo '</pre>';
        // echo '</br>';
        // echo $personal_gpv;
        // echo '</br>';
        // echo $right;

        //return $active_do;
    }
    //Calculate Personal GPV without personal PV
    //END

    public function calculate_total_group_pv()
    {
        $users = User::all();

        foreach($users as $user)
        {
            $total_pv = 0;

            if($user->rank_id >= 4)
            {
                $node        = Referral::where('user_id', $user->id)->first();
                $descendants = $node->getDescendantsAndSelf(); 
                
                foreach($descendants as $descendant)
                {
                    $wallet = Wallet::where('user_id', $descendant->user_id)->first();
                    $total_pv = $total_pv + (is_null($wallet) ? 0:$wallet->pv);
                }

                $active_do = ActiveDo::where('user_id', $user->id)->first();
                $active_do->total_group_pv = $total_pv;
                $active_do->save();
            }
        }
    }

    //calculate 3 generations active do group bonus
    public function group_bonus($user_id)
    {
        $root = Referral::where('user_id', $user_id)->first();
        $root_wallet        = Wallet::where('user_id', $user_id)->first();

        
        $descendants        = $root->getDescendants();
        $active_do_members  = array();

        $generation         = 2;
        $root_rgt           = $root->rgt;//gen1
        $rgt_gen2           = 0;
        $rgt_gen3           = 0;

        $bonus_gen2         = 0;
        $bonus_gen3         = 0;

        foreach ($descendants as $descendant ) 
        {
            $wallet = Wallet::where('user_id', $descendant->user_id)->first();
            $rank = $this->getUserRankId($descendant->user_id);
            $rgt  = $descendant->rgt;

            if($rank >= 4)
            {
                if($generation == 2 && ($rgt < $root_rgt && $rgt > $rgt_gen2))
                {
                    $rgt_gen2           = $descendant->rgt;
                    $active_do_members[]= $descendant->toArray();

                    $bonus_gen2         = $bonus_gen2 + $wallet->pv; 

                    $bonus                = new Bonus;
                    $bonus->user_id       = $root->user_id;
                    $bonus->bonus_type_id = 7;
                    $bonus->amount        = (number_format(0.05, 2) *($wallet->pv - $wallet->first_purchased)) + (number_format(0.05, 2)*$wallet->first_purchased);
                    $bonus->description   = "Do Group Bonus Gen 2";
                    $bonus->from_user_id  = $descendant->user_id;
                    $bonus->save();
                
                    if(!$descendant->isLeaf())
                    {
                        $generation = 3;
                        $rgt_gen2   = $descendant->rgt;
                    }
                }
                elseif($generation == 3 && ($rgt < $rgt_gen2 && $rgt > $rgt_gen3))
                {
                    $rgt_gen3           = $descendant->rgt;
                    $active_do_members[]= $descendant->toArray();

                    $bonus_gen3         = $bonus_gen3 + $wallet->pv; 

                    $bonus->user_id       = $root->user_id;
                    $bonus->bonus_type_id = 7;
                    $bonus->amount        = (number_format(0.05, 2) *($wallet->pv - $wallet->first_purchased)) + (number_format(0.05, 2)*$wallet->first_purchased);
                    $bonus->description   = "Do Group Bonus Gen 3";
                    $bonus->from_user_id  = $descendant->user_id;
                    $bonus->save();
                }
                elseif($generation == 3 && ($rgt > $rgt_gen2 && $rgt < $root_rgt ))
                {
                    $rgt_gen2           = $descendant->rgt;
                    $active_do_members[]= $descendant->toArray();

                    $bonus_gen2         = $bonus_gen2 + $wallet->pv; 

                    $bonus->user_id       = $root->user_id;
                    $bonus->bonus_type_id = 7;
                    $bonus->amount        = (number_format(0.05, 2) *($wallet->pv - $wallet->first_purchased)) + (number_format(0.05, 2)*$wallet->first_purchased);
                    $bonus->description   = "Do Group Bonus Gen 2";
                    $bonus->from_user_id  = $descendant->user_id;
                    $bonus->save();
                
                    if(!$descendant->isLeaf())
                    {
                        $generation = 3;
                        $rgt_gen2   = $descendant->rgt;
                    }
                }  
            }

        }

        $do_bonus = 0;//descendants personal group pv
        $root_gpv = ActiveDo::where('user_id', $user_id)->first()->personal_gpv;
        $root_first_purchased  = ActiveDo::where('user_id', $user_id)->first()->first_gpv_purchased;
        $total_gpv = $root_gpv;
        $total_first_gpv = $root_first_purchased; 

        foreach ($active_do_members as $member) 
        {  
            $do_member = ActiveDo::where('user_id', $member['user_id'])->first(); 

            $total_gpv          = $total_gpv + $do_member->personal_gpv;
            $total_first_gpv    = $total_first_gpv + $do_member->first_gpv_purchased;
        }

        $first_group_bonus  = $total_first_gpv * number_format(5/100, 2, '.', '');
        $second_group_bonus = ($total_gpv - $total_first_gpv) * number_format(12/100, 2, '.', '');
        $total_group_bonus  = $first_group_bonus + $second_group_bonus;


        // if($total_group_bonus > 0){
        //     $bonus = new Bonus;
        //     $bonus->user_id       = $user_id;
        //     $bonus->bonus_type_id = 8; //8 for DO Bonus Group 3 Generations
        //     $bonus->amount        = $total_group_bonus;
        //     $bonus->description   = "Do Group Bonus 3 Generations #15-36%";
        //     $bonus->save();
        // }

        if(($total_gpv > 0 || $total_group_bonus > 0) && ($root_wallet && $root_wallet->pv >= 100)){
            $active_do = ActiveDo::where('user_id', $user_id)->first();
            $active_do->generations_gpv = $total_gpv;
            $active_do->do_group_bonus  = $total_group_bonus;
            $active_do->gen_first_purchased = $total_first_gpv;
            $active_do->save();
        }
    }

    public function do_cto_bonus()
    {
        $do_members = ActiveDo::all();
        $cnt = 0;
        $dp  = 0;
        $total_dp   = 0;
        $overall_dp = 0;
        $right      = 0;

        $qualified_members = array();

        $year  = (new DateTime)->format("Y");
        $month = (new DateTime)->format("n");

        if($month == 1){
            $month = 12;
            $year  = $year - 1;
        } else {
            $month = $month - 1;
        }


        $sale = Sale::where('month', $month)->where('year', $year)->first();//100000; //set default to 100k for testing
        $total_sale = $sale->total_sale; //MYR
        $total_pv   = $sale->total_pv; //Point 

        $cto_pool = number_format((8/100*$total_pv), 2, '.', ''); //8% do cto bonus

        $total_shares = 0;
        $total_group_pv = 0;

        foreach ($do_members as $member) 
        {
           $node        = Referral::where('user_id', $member->user_id)->first();
           //$descendants = $node->getImmediateDescendants();
           $descendants = $node->getDescendants();

           foreach ($descendants as $descendant) 
           {
               //$do = ActiveDo::where('user_id', $descendant->user_id)->first();

               // if(!is_null($do) && $do->personal_gpv >= 5000)
               // {
               //      $cnt = $cnt + 1;
               //      $qualified_members[] = $do->personal_gpv;
               // }
                $rank = $this->getUserRankId($descendant->user_id);
                
                if($rank >= 4 && $descendant->rgt > $right)
                {
                    $do = ActiveDo::where('user_id', $descendant->user_id)->first();
                    //if(!is_null($do) && $do->personal_gpv >= 5000)//original
                    if(!is_null($do) && $do->total_group_pv >= 5000)
                    {
                        $cnt = $cnt + 1;
                        $qualified_members[] = $do->total_group_pv;

                        $right = $descendant->rgt;
                    }
                    
                }
           }

           $right = 0;

           if(count($qualified_members) > 2)
           {
                if(count($qualified_members) >= 5)
                {
                    $active_do = ActiveDo::where('user_id', $member->user_id)->first();
                    
                    if($active_do->rank == 'District Officer')
                    {
                        $merit = new SdoMerit;
                        $merit->user_id = $member->user_id;
                        $merit->branch5 = $merit->branch5 + 1;
                        $merit->save();
                        // $active_do->branch5 = $active_do->branch5 + 1;
                        // $active_do->save();

                        //check if qulified to upgrade to sdo or not
                    }
                    // else
                    // {
                    //     $sdo_license = SdoLicense::firstOrNew(['user_id' => $member->user_id]);
                    //     $sdo_license->branch5 = $sdo_license->branch5 + 1;
                    //     $sdo_license->save();
                    // } 
                }
                else 
                {
                    $active_do = ActiveDo::where('user_id', $member->user_id)->first();

                    if($active_do->rank == 'District Officer')
                    {
                        
                        $merit = new SdoMerit;
                        $merit->user_id = $member->user_id;
                        $merit->branch3 = $merit->branch3 + 1;
                        $merit->save();

                        //check if qulified to upgrade to sdo or not
                    }
                    // else
                    // {
                    //     $sdo_license = SdoLicense::firstOrNew(['user_id' => $member->user_id]);
                    //     $sdo_license->branch5 = $sdo_license->branch5 + 1;
                    //     $sdo_license->save();
                    // } 
                }

                $partitions = array_chunk($qualified_members, 3);

                $n_array = count($partitions);

                for($i = 0; $i < $n_array; $i++)
                {
                    if(count($partitions[$i]) == 3)
                    {
                        $min = min($partitions[$i]);
                        echo "<br/>";
                        echo "<pre>";
                        print_r($partitions[$i]);    
                        echo "<pre/>";
                        print_r($min);
                        echo "<br/>";
                        echo $n_array;
                        echo "<br/>";

                        if($min < 40000)
                        {
                            $dp = floor($min/5000);

                            if($dp > 3) $dp = 3;   
                        }
                        elseif($min >= 40000 && $min < 60000)
                        {
                            $dp = 4;
                        }elseif($min >= 60000) $dp = 5;
                    } 

                    $total_dp = $total_dp + $dp;
                    $dp = 0;
                }
           }

            $active_member = ActiveDo::where('user_id', $member->user_id)->first();
            $active_member->cto_unit_share = $total_dp;
            $active_member->save();

            $overall_dp = $overall_dp + $total_dp;
            $total_dp   = 0;
            $dp         = 0;
            $qualified_members = null;
            echo 'overall dp = '.$overall_dp;
            echo '<br/>';
            echo 'user_id ='. $member->user_id;
            echo '<br/>';
        }

        $cto_value_share = number_format($cto_pool/$overall_dp, 2, '.', ''); //value share perunit
        echo $total_pv;
        echo '<br/>';
        echo 'CTO Value Share Perunit = '.$cto_value_share;
        echo '<br/>';

        $sale->do_cto_val_unit = $cto_value_share;
        $sale->save();

        $updateDos = ActiveDo::where('cto_unit_share', '>', 0)->get();

        foreach($updateDos as $updateDo){
            $updateDo->cto_value_share = $updateDo->cto_unit_share * $cto_value_share;
            $updateDo->save();
        }
    }

    public function sdo_cto_bonus()
    {
        //5% bonus - requirement 5k from 5 direct sponsor
        $sdo_members    = ActiveSdo::all();

        $qualified_members = array();

        $sales          = 100000; //set default to 100k for testing

        $cto_pool       = (5/100)*$sales; //5% sdo cto bonus

        $total_shares   = 0;
        $shares = 0;

        foreach($sdo_members as $member)
        {
            $members_5k     = 0;
            $root = Referral::where('user_id', $member->user_id)->first();

            $children = $root->getDescendants();

            if(count($children) >= 4)
            {
                foreach ($children as $child)
                {
                    $wallet = Wallet::where('user_id', $child->user_id)->first();
                    if($wallet && $wallet->pv >= 5000)
                    {
                        $members_5k++;
                        $qualified_members[] = $child;
                    } 
                }

                if($members_5k/5 > 0)
                {
                    $shares = floor($members_5k/5);

                    $qualified_members[] = $root;
                    //     'user_id' => $member->user_id,
                    //     'shares'  => $shares
                    // ];

                    // $active_sdo = ActiveSdo::where('user_id', $member->user_id)->first();
                    // $active_sdo->cto_unit_share = $shares;
                    // $active_sdo->save();
                }
            }

            $total_shares   = $total_shares + $shares;
        }

        if($total_shares > 0) $cto_value_per_unit = number_format(($cto_pool/$total_shares), 2, '.', '');
        else $cto_value_per_unit = 0;

        if(count($qualified_members) > 0)
        {
            $i = 0;
            foreach ($qualified_members as $qmember)
            {
                // $qualified_sdo = ActiveSdo::where('user_id', $qmember[$i++]['user_id'])->first();
                // $qualified_sdo->cto_unit_share = $qmember[$i++]['shares'];
                // $qualified_sdo->cto_value_share= $qmember[$i++]['shares'] * $cto_value_per_unit;
                // $qualified_sdo->save();
                // echo '<br>';
                // echo '<pre>';
                // print_r($qmember);
                // echo '</pre>';
                echo $qmember[$i++]['user_id'];
            }
        }
        
    }

    //Calculate Personal GPV without personal PV
    public function calculate_active_sdo_personal_gpv($user_id)
    {
        //return $active_do;
        $root = Referral::where('user_id', $user_id)->first();
        $root_wallet = Wallet::where('user_id', $user_id)->first();
 
        $descendants = $root->getDescendants();
        $first_pv_purchased = 0;
        $personal_gpv = 0;
        $first_gpv_purchased = $root_wallet ? $root_wallet->first_purchased:0;
        $right        = 0;
        $qualified    = array();

        foreach ($descendants as $descendant)
        {
            $rank = $this->getUserRankId($descendant->user_id);

            if($rank <= 4 && $descendant->rgt > $right)
            {
                $wallet = Wallet::where('user_id', $descendant->user_id)->first();

                $first_gpv_purchased = $first_gpv_purchased + ($wallet ? $wallet->first_purchased:0) ;
                $personal_gpv = $personal_gpv + ($wallet ? $wallet->pv:0);//without root personal pv
                $qualified[]  = $descendant->toArray();
            }
            elseif ($rank > 4 )
            {
                if($right < $descendant->rgt)
                {
                    $right = $descendant->rgt;
                }
            }
        }

        $root_wallet = Wallet::where('user_id', $user_id)->first();//root personl pv

        $active_do = ActiveDo::where('user_id', $user_id)->first();
        $active_do->personal_gpv = $personal_gpv + ($root_wallet ? $root_wallet->pv:0);
        $active_do->first_gpv_purchased = $first_gpv_purchased;
        $active_do->save();
    }

    public function sdo_bonus($user_id)
    {
        //2% bonus
        $wallet = Wallet::where('user_id', $user_id)->first();

        $personal_pv    = !is_null($wallet) ? $wallet->pv: null;
        $sdo            = ActiveSdo::where('user_id', $user_id)->first();

        if(!is_null($wallet) && $wallet->pv > 0)
        {
          $personal_gpv   = $sdo->personal_gpv;
          $sdo_bonus      = (2/100)*($personal_pv + $personal_gpv);

          $sdo->sdo_group_bonus = number_format($sdo_bonus, 2, '.', '');
          $sdo->save();
        }
    }

    public function sdo_to_sdo_bonus($user_id)
    {
        $root              = Referral::where('user_id', $user_id)->first();
        $descendants       = $root->getDescendants();
        $active_sdo_members = array();
        $generation        = 1;
        $rgt_root          = $root->rgt;
        $rgt_generation[0] = $root->rgt ; //value for first time process
        $rgt_generation[1] = 0; //generation 1

        $bonus_generation[0]  =  0; //root
        $bonus_generation[1]  =  0; //generation 1

        foreach($descendants as $descendant)
        {
            $wallet = Wallet::where('user_id', $descendant->user_id)->first();

            if($descendant->rank == 'SDO' && ($wallet && $wallet->pv >= 200))
            {
                if($descendant->rgt < $rgt_generation[0] && $descendant->rgt > $rgt_generation[1]);
                {
                    $rgt_generation[1]   = $descendant->rgt;
                    $active_sdo_members[] = $descendant->toArray();

                    $bonus_generation[1] = $bonus_generation[1] + $wallet->pv;
                }
            }
        }

        $sdo_bonus = 0;//personal group pv

        foreach ($active_sdo_members as $member) {
            //$do_member = DoMember::where('user_id', $member['user_id'])->first();
            $sdo_member = ActiveSdo::where('user_id', $member['user_id'])->first();
            $sdo_bonus  = $sdo_bonus + $sdo_member->personal_gpv;
        }

        $generations_gpv = $bonus_generation[1];

        //$generations_gpv = number_format(((7/100) * $do_bonus), 2, '.', '');
        $group_bonus    = number_format(((2/100) * ($sdo_bonus + $generations_gpv)), 2, '.', '');
        $root_wallet    = Wallet::where('user_id', $user_id)->first();
        $root_pv        = $root->pv;

        if($group_bonus > 0){
            $bonus = new Bonus;
            $bonus->user_id       = $user_id;
            $bonus->bonus_type_id = 12; //8 for SDO To SDO Bonus
            $bonus->amount        = $group_bonus;
            $bonus->description   = "SDO To SDO Bonus #2%";
            $bonus->save();
        }

        if($generations_gpv > 0){
            $active_sdo = ActiveSdo::where('user_id', $user_id)->first();
            $active_sdo->sdo_to_sdo_bonus = $generations_gpv;
            $active_sdo->save();
        }

        /*echo '<pre>';
        print_r($active_do_members);
        echo '</pre>';
        echo '</br>';*/
        echo 'sdo bonus = '. $sdo_bonus;
        echo '</br>';
        echo 'genaration bonus = '.$group_bonus;
        echo '</br>';
        echo 'genaration gpv = '.$generations_gpv;
        echo '</br>';
        //return $active_do;
    }

    public function getUpline($id)
    {
        $referral   = Referral::where('user_id', $id)->first();
        if($referral)
        {
            $parent_id  = $referral->parent_id;
            $upline     = Referral::where('user_id',$parent_id)->first();
        }
        else
        {
            $upline = null;
        }
        
        return $upline;
    }

    public function getUserRank($id) //get rank name
    {
        $user = User::find($id);
        $rank = $user->rank->name;

        return $rank;
    }

    public function getUserRankId($id) //get rank id
    {
        //return ( $id = 0 || $id = 'null') ? 'null' : $rank_id = User::find($id)->rank_id;
        $user = User::find($id);
        $rank = $user != null ? $user->rank_id: 0;

        return $rank;
    }

    public function getPersonalRebate($user_id)
    {
        $user  = User::find($user_id);
        $rank = $user->rank->name;

        if($rank == 'Loyal Customer')
        {
            $bonustype  = BonusType::where('name', 'Personal Rebate LC')->first();
            $rebate     = $bonustype->value;
        }
        elseif( $rank == 'Marketing Officer')
        {
            $bonustype  = BonusType::where('name', 'Personal Rebate MO')->first();
            $rebate     = $bonustype->value;
        }
        elseif( $rank == 'District Officer')
        {
            $bonustype  = BonusType::where('name', 'Personal Rebate DO')->first();
            $rebate     = $bonustype->value;
        }
        elseif ($rank == 'Senior District Officer')
        {
            $bonustype  = BonusType::where('name', 'Personal Rebate SDO')->first();
            $rebate     = $bonustype->value;
        } else {
            $rebate = 0;
        }

        return $rebate;
    }

    public function recordUserBonuses()
    {
        // $retail_profit;
        // $personal_rabate;
        // $direct_sponsor;
        // $group; //DO & SDO up to @ 2 GEN DO/SDO below
        // $do_cto; //DO
        // $sdo_group; //SDO
        // $sdo_cto; //SDO

        $users = User::with(['wallet', 'active_do', 'active_sdo'])->get();
        foreach ($users as $user) {
            $bonus = new UserBonus;
            $bonus->user_id         = $user->id;
            $bonus->retail_profit   = $user->wallet->retail_profit;
            $bonus->personal_rebate = $user->wallet->personal_rebate;
            $bonus->direct_sponsor  = $user->wallet->direct_sponsor;
            $bonus->do_group_bonus  = $user->active_do->do_group_bonus;
            $bonus->sdo_group_bonus = $user->active_sdo->sdo_group_bonus;
            $bonus->sdo_sdo         = $user->active_sdo->sdo_to_sdo_bonus;
            $bonus->do_cto_pool     = $user->active_do->cto_value_share;
            $bonus->sdo_cto_pool    = $user->active_sdo->cto_value_share;
            $bonus->total_bonus     = $this->countTotalBonus($user);
            $bonus->month           = Carbon::now()->month;
            $bonus->year            = Carbon::now()->year;
            $bonus->save();
        }



        // $activeUsers = activeUsers($users);
        // array_walk($activeUsers, 'recordBonus');

    }

    public function countTotalBonus($user)
    {
        $totalBonus = $user->wallet->retail_profit + $user->wallet->personal_rebate + $user->wallet->direct_sponsor 
                      + $user->active_do->do_group_bonus + $user->active_sdo->sdo_group_bonus + $user->active_sdo->sdo_to_sdo_bonus
                      + $user->active_do->cto_value_share + $user->active_sdo->cto_value_share;

        return $totalBonus;
    }

    // public function activeUsers($users)
    // {
    //     return array_filter($users, 'isUserActive');
    // }

    // public function isUserActive($user)
    // {
    //     $userRecord = Wallet::where('user_id', $user->id)->first();
    //     return !is_null($userRecord);
    // }

    // public function recordBonus()
    // {
    //     $bonus = new Bonus();
    //     $bonus->retail_profit = 
    // }

    public function bonusStatement($id)
    {
        $user = User::find($id);

        $bonuses = $user->userBonus;    

        return view('bonus.bonus-statement', compact('user','bonuses'));    
    }

    public function bonusDetails($id)
    {

        $userBonus = UserBonus::find($id);

        $retail_profit          = Bonus::where('user_id', $userBonus->user_id)
                                        ->where('bonus_type_id','1')
                                        ->sum('amount');

        $override_retail_profit = Bonus::where('user_id', $userBonus->user_id)
                                        ->where('bonus_type_id','2')
                                        ->sum('amount');

        $personal_rebate        = Bonus::where('user_id', $userBonus->user_id)
                                        ->where('bonus_type_id','3')
                                        ->sum('amount');

        $override_personal_rebate   = Bonus::where('user_id', $userBonus->user_id)
                                            ->where('bonus_type_id','4')
                                            ->sum('amount');

        $direct_sponsor         = Bonus::where('user_id', $userBonus->user_id)
                                        ->where('bonus_type_id','5')
                                        ->sum('amount');

        $indirect_sponsor       = Bonus::where('user_id', $userBonus->user_id)
                                        ->where('bonus_type_id','6')
                                        ->sum('amount');

        $root           = Referral::where('user_id', $userBonus->user_id)->first();
        // echo $root;
        $descendants    = $root->getDescendants();

        $downlines      = array();

        if($descendants)
        {
            foreach ($descendants as $descendant) {
            $wallet = Wallet::where('user_id', $descendant->user_id)->first();

                if($wallet->pv > 0 || $wallet->first_purchased > 0)
                {
                    $downlines[] = [
                                'username'          => $wallet->user->username,
                                'rank_id'           => $wallet->user->rank_id,
                                'pv'                => $wallet->pv,
                                'first_purchased'   => $wallet->first_purchased,
                                // 'retail_profit'     => Bonus::where('from_user_id', $root->user_id)
                                //                         ->where('user_id', $root->user_id)
                                //                         ->where('bonus_type_id','1')
                                //                         ->sum('amount'),
                                'override_retail_profit' => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $root->user_id)
                                                        ->where('bonus_type_id','2')
                                                        ->sum('amount'),
                                'personal_rebate'   => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $wallet->user_id)
                                                        ->where('bonus_type_id','3')
                                                        ->sum('amount'),
                                'override_personal_rebate'   => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $root->user_id)
                                                        ->where('bonus_type_id','4')
                                                        ->sum('amount'),
                                'direct_sponsor'    => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $root->user_id)
                                                        ->where('bonus_type_id','5')
                                                        ->sum('amount'),
                                'indirect_sponsor'  => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $root->user_id)
                                                        ->where('bonus_type_id','6')
                                                        ->sum('amount'),
                                'group_bonus'       => Bonus::where('from_user_id', $wallet->user_id)
                                                        ->where('user_id', $root->user_id)
                                                        ->where('bonus_type_id','7')
                                                        ->sum('amount'),
                                // 'do_cto'            => $wallet->do_cto,
                                // 'sdo_cto'           => $wallet->sdo_cto,
                                // 'sdo_group'         => $wallet->sdo_group,
                                // 'sdo_to_sdo'        => $wallet->sdo_to_sdo, 
                                ]; 
                }
            }
        }
        

        // dd($downlines);

        return view('bonus.bonus-details', compact('userBonus',
                                                   'retail_profit',
                                                   'override_retail_profit',
                                                   'personal_rebate',
                                                   'override_personal_rebate',
                                                   'direct_sponsor',
                                                   'indirect_sponsor',
                                                   'downlines'
                                                  ));
    }


    public function getMembersOfThreeGenDo($id)
    {
        $root = Referral::where('user_id', $id)->first();
        $second_rgt = 0;

        $first_gen_members = array();
        $second_gen_members= array();
        $third_gen_members = array();

        $referrals = $root->getDescendants();
        
        foreach ($referrals as $referral) {
            $rank = $this->getUserRankId($referral->user_id);

            if ($rank < 4 && ($referral->rgt < $root->rgt && $referral->rgt > $second_rgt)) {
                $wallet = Wallet::where('user_id', $referral->user_id)->first();
                if($wallet->pv > 0 || $wallet->first_purchased)
                {
                    $first_gen_members[] = $referral->toArray();
                } 
            } 
            else
            {
                $second_rgt = $referral->rgt;
            } 
        }

        $second_gen_do_members = $this->getSecondGenDoMembers($id);
        $third_gen_do_members  = $this->getThirdGenDoMembers($second_gen_do_members);

        dump($second_gen_do_members);
        echo '<br>';
        dump($third_gen_do_members);


    }

    public function getSecondGenDoMembers($id)
    {
        $root = Referral::where('user_id', $id)->first();
        $rgt  = $root->rgt;

        $secondGenRgt = 0;

        $second_gen_do_members = array();

        $descendants = $root->getDescendants();

        foreach ($descendants as $descendant) 
        {
            $rank = $this->getUserRankId($descendant->user_id);

            if($rank >= 4 && ($descendant->rgt > $secondGenRgt && $descendant->rgt < $rgt)){

                $second_gen_do_members[] = $descendant->toArray();
                $secondGenRgt    = $descendant->rgt;

            }
        }

        return $second_gen_do_members;
    }

    public function getThirdGenDoMembers($secondGenDoMembers)
    {
        $third_gen_do_members = array();

        if(!is_null($secondGenDoMembers))
        {
            foreach ($secondGenDoMembers as $member) 
            {
                
                $root = Referral::where('user_id', $member['user_id'])->first();
                $rgt  = $root->rgt;

                $secondGenRgt = 0;

                $descendants = $root->getDescendants();

                foreach ($descendants as $descendant) {
                    $rank = $this->getUserRankId($descendant->user_id);

                    if($rank >= 4 && ($descendant->rgt > $secondGenRgt && $descendant->rgt < $rgt)){

                        $third_gen_do_members[] = $descendant->toArray();
                        $secondGenRgt    = $descendant->rgt;

                    }
                }         
            }
        }

        return $third_gen_do_members;
    }

    // public function getDoDownlines($id)
    // {

    // }
}
