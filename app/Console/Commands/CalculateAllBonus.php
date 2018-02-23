<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;
use Storage;
use DB;
use Mail;

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

use Validator;
use Session;
use DateTime;

class CalculateAllBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:allbonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate All Bonus';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //backup database before calculation
        //set filename with date and time of backup
        $filename = "backup-" . Carbon\Carbon::now()->format('Y-m-d_H-i-s') . ".sql.gz";

        //mysqldump command with account credentials from .env file. storage_path() adds default local storage path
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " | gzip > " . storage_path() . "/backup/" . $filename;

        $returnVar = NULL;
        $output  = NULL;
        //exec command allows you to run terminal commands from php 
        exec($command, $output, $returnVar);

        //if nothing (error) is returned
        if(!$returnVar){
            //get mysqldump output file from local storage
            //$getFile = Storage::disk('local')->get($filename);
            // put file in backups directory on s3 storage

            // $do_members     = ActiveDo::all();
            // $sdo_members    = ActiveSdo::all();
            // $userPurchases  = UserPurchase::all();
            // $userStores     = Store::all();
            // $next_do_members= $do_members;
            // $i              = 0;
            // $n              = count($do_members);

            //count for DO Rank Members
            $do_members     = ActiveDo::all();
            $sdo_members    = ActiveSdo::all();
            //$userPurchases  = UserPurchase::all();  // originall
            $userPurchases  = UserPurchase::groupBy('user_id', 'product_id')
                                ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')->get();
            //$userStores     = Store::all(); // originall
            $userStores     = Store::groupBy('user_id', 'product_id')
                                ->selectRaw('user_id, product_id, sum(price) as price, sum(pv) as pv, count(*) as quantity')->get();
            $next_do_members= $do_members;
            $i              = 0;
            $n              = count($do_members);

            $total_sales1   = UserPurchase::sum('price');
            $total_sales2   = Store::sum('price');
            $total_sales    = $total_sales1 + $total_sales2;

            $total_pv1      = UserPurchase::sum('pv');
            $total_pv2      = Store::sum('pv');
            $total_pv       = $total_pv1 + $total_pv2;

            $year   = (new DateTime)->format("Y");
            $month  = (new DateTime)->format("n");
            if($month == 1){
                $month = 12;
            } else {
                $month = $month - 1;
            }

            $sale   = Sale::where('year', $year)->where('month', $month)->first();
            $sale->total_sale = $total_sales;
            $sale->total_pv   = $total_pv;
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
        }
        else 
        {
            // if there is an error send an email 
            Mail::raw('There has been an error backing up the database.', function ($message) {
                $message->to("rich@example.com", "Rich")->subject("Backup Error");
            });
        }

        // DB::table('wallets')->where('1')->update([])
    }

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
                }   
            }
            elseif($data['rank'] == 2)
            {
                $wallet = Wallet::where('user_id', $data['user_id'])->first();

                if(!is_null($wallet))
                {
                    $wallet->retail_profit = $wallet->retail_profit +(number_format(0.05, 2) * $data['total_price']);
                    $wallet->save();
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
                $bonus->bonus_type_id   = $user_rank - 1;
                $bonus->amount          = $evoucher;
                $bonus->description     = "Personal Rebate Purchase For Product: ".$product->name." Bonus: ". $evoucher ."%";
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
            $last_rebate    = $this->getPersonalRebate($id);

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
                        $bonus->bonus_type_id   = $parent_rank - 1;
                        $bonus->amount          = $evoucher;
                        $bonus->description     = "Override PR Downline Purchase ".$downline->username . " Override Bonus: ". 20 ."%";
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
        $parent_rank    = $this->getUserRankId(is_null($parent) ? 0 : $parent->user_id );
        $parent_wallet  = Wallet::where('user_id', $parent->user_id)->first();

        //if($node_rank > 2 && ($node_rank <= $parent_rank) )
        if(!is_null($parent) )
        {
            if($parent_rank > 2 && ($node_rank <= $parent_rank) )
            {
                // $bonus          = number_format(0.5, 2);
                $first_bonus        = $first_pv * number_format(0.5, 2);
                $second_bonus       = $second_pv * number_format(0.2, 2);

                if($parent_wallet && $parent_wallet->pv >= 100)
                {
                    $parent_wallet->direct_sponsor = $parent_wallet->direct_sponsor + ($first_bonus + $second_bonus); 
                    $parent_wallet->save();
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
                }
                elseif($generation == 3 && ($rgt > $rgt_gen2 && $rgt < $root_rgt ))
                {
                    $rgt_gen2           = $descendant->rgt;
                    $active_do_members[]= $descendant->toArray();

                    $bonus_gen2         = $bonus_gen2 + $wallet->pv; 
                
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

        if($total_group_bonus > 0){
            $bonus = new Bonus;
            $bonus->user_id       = $user_id;
            $bonus->bonus_type_id = 8; //8 for DO Bonus Group 3 Generations
            $bonus->amount        = $total_group_bonus;
            $bonus->description   = "Do Group Bonus 3 Generations #15-36%";
            $bonus->save();
        }

        $root_rank = $this->getUserRankId($user_id);

        if(($total_gpv > 0 || $total_group_bonus > 0) && (($root_wallet && $root_wallet->pv >= 100) || $root_rank == 5)){
            $active_do = ActiveDo::where('user_id', $user_id)->first();
            $active_do->generations_gpv = $total_gpv;
            $active_do->do_group_bonus  = $total_group_bonus;
            $active_do->gen_first_purchased = $total_first_gpv;
            $active_do->save();
        }

        // $root              = Referral::where('user_id', $user_id)->first();
        // $descendants       = $root->getDescendants();
        // $active_do_members = array();
        // $generation        = 1;
        // //$rgt_root          = $root->rgt;
        // $rgt_generation[0] = $root->rgt ; //value for first time process
        // $rgt_generation[1] = 0; //generation 1
        // $rgt_generation[2] = 0; //generation 2
        // $bonus_generation[0]  = 0; //root
        // $bonus_generation[1]  = 0; //generation 1
        // $bonus_generation[2]  = 0; //generation 2
        
        // $root_first_purchased  = ActiveDo::where('user_id', $user_id)->first()->first_gpv_purchased;

        // foreach($descendants as $descendant)
        // {
        //     $wallet = Wallet::where('user_id', $descendant->user_id)->first();
        //     $descendant_rank = $this->getUserRankId($descendant->user_id);

        //     if($descendant_rank >= 4 && ($wallet && $wallet->pv >= 100))
        //     {
        //         //$do = ActiveDo::where('user_id',$descendant->user_id)->first();

        //         if($generation == 1 && ($descendant->rgt < $rgt_generation[0] && $descendant->rgt > $rgt_generation[1]))
        //         {
        //             $rgt_generation[1]   = $descendant->rgt;
        //             $active_do_members[] = $descendant->toArray();

        //             $bonus_generation[1] = $bonus_generation[1] + $wallet->pv; 
                
        //             if(!$descendant->isLeaf())
        //             {
        //                 $generation = 2;
        //                 $rgt_generation[2]   = $descendant->rgt;
        //             }
        //         }
        //         elseif($generation == 2 && ($descendant->rgt < $rgt_generation[1] && $descendant->rgt > $rgt_generation[2]))
        //         {
        //             $rgt_generation[2]   = $descendant->rgt;
        //             $active_do_members[] = $descendant->toArray();

        //             $bonus_generation[2] = $bonus_generation[2] + $wallet->pv;

        //             if(!$descendant->isLeaf())
        //             {
        //                 $generation = 3;
        //             }
        //         }

        //         // elseif($generation == 3 && $descendant->rgt < $rgt_generation[2] && $descendant->rgt > $rgt_generation[3])
        //         // {
        //         //     $rgt_generation[3]   = $descendant->rgt;
        //         //     $active_do_members[] = $descendant->toArray();

        //         //     $bonus_generation[3] = $bonus_generation[3] + $wallet->pv;
        //         // }
        //         elseif($generation == 3 && $descendant->rgt > $rgt_generation[2] && $descendant->rgt < $rgt_generation[1])
        //         {
        //             $generation          = 2;
        //             $rgt_generation[2]   = $descendant->rgt;
        //             $active_do_members[] = $descendant->toArray();

        //             $bonus_generation[2] = $bonus_generation[2] + $wallet->pv;
                    

        //             if(!$descendant->isLeaf())
        //             {
        //                 $generation = 3;
        //             }
        //         }
        //         elseif($generation == 3 && $descendant->rgt > $rgt_generation[1] && $descendant->rgt < $rgt_generation[0])
        //         {
        //             $generation          = 1;
        //             $rgt_generation[1]   = $descendant->rgt;
        //             $active_do_members[] = $descendant->toArray();

        //             $bonus_generation[1] = $bonus_generation[1] + $wallet->pv;

        //             if(!$descendant->isLeaf())
        //             {
        //                 $generation = 3;
        //             }
        //         }
        //     }
        // }

        // $do_bonus = 0;//descendants personal group pv
        // $root_gpv = ActiveDo::where('user_id', $user_id)->first()->personal_gpv;
        // $total_gpv = $root_gpv;
        // $total_first_gpv = $root_first_purchased;

        // foreach ($active_do_members as $member) 
        // {  
        //     $do_member = ActiveDo::where('user_id', $member['user_id'])->first(); 

        //     $total_gpv = $total_gpv + $do_member->personal_gpv;
        //     $total_first_gpv = $total_first_gpv + $do_member->first_gpv_purchased;

        //     echo '<br/>';
        //     echo  $member['user_id'];
        //     echo '<br/>';
        // }

        // // $generations_gpv = $root_gpv + $bonus_generation[1] + $bonus_generation[2];// + $bonus_generation[3];
        // $first_group_bonus = $total_first_gpv * number_format(5/100, 2, '.', '');
        // $second_group_bonus = ($total_gpv - $total_first_gpv) * number_format(12/100, 2, '.', '');

        // //$generations_gpv = number_format(((7/100) * $do_bonus), 2, '.', '');
        // $total_group_bonus    = $first_group_bonus + $second_group_bonus;
        // $root_wallet = Wallet::where('user_id', $user_id)->first();

        // if($total_group_bonus > 0){
        //     $bonus = new Bonus;
        //     $bonus->user_id       = $user_id;
        //     $bonus->bonus_type_id = 8; //8 for DO Bonus Group 3 Generations
        //     $bonus->amount        = $total_group_bonus;
        //     $bonus->description   = "Do Group Bonus 3 Generations #15-36%";
        //     $bonus->save();
        // }

        // if(($total_gpv > 0 || $total_group_bonus > 0) && ($root_wallet && $root_wallet->pv >= 100)){
        //     $active_do = ActiveDo::where('user_id', $user_id)->first();
        //     $active_do->generations_gpv = $total_gpv;
        //     $active_do->do_group_bonus  = $total_group_bonus;
        //     $active_do->gen_first_purchased = $total_first_gpv;
        //     $active_do->save();
        // }

        /*echo '<pre>';
        print_r($active_do_members);
        echo '</pre>';
        echo '</br>';*/
        // echo 'do bonus = '. $do_bonus;
        // echo '</br>';
        // echo 'genaration bonus = '.$group_bonus;
        // echo '</br>';
        // echo 'genaration gpv = '.$generations_gpv;
        // echo '</br>';
        //return $active_do;
        //echo $total_first_gpv;
    }

    public function do_cto_bonus()
    {
        $do_members = ActiveDo::all();
        $cnt = 0;
        $dp  = 0;
        $total_dp   = 0;
        $overall_dp = 0;

        $qualified_members = array();

        $year  = (new DateTime)->format("Y");
        $month = (new DateTime)->format("n") - 1;

        $sale = Sale::where('month', $month)->where('year', $year)->first();//100000; //set default to 100k for testing
        $total_sale = $sale->total_sale; //MYR
        $total_pv   = $sale->total_pv; //Point 

        $cto_pool = number_format((8/100*$total_pv), 2, '.', ''); //8% do cto bonus

        $total_shares = 0;
        $personal_gpv = 0;

        foreach ($do_members as $member) 
        {
           $node        = Referral::where('user_id', $member->user_id)->first();
           $descendants = $node->getImmediateDescendants();

           foreach ($descendants as $descendant) 
           {
               $do = ActiveDo::where('user_id', $descendant->user_id)->first();

               if(!is_null($do) && $do->personal_gpv >= 5000)
               {
                    $cnt = $cnt + 1;
                    $qualified_members[] = $do->personal_gpv;
               }
           }

           if(count($qualified_members) > 2)
           {
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

        // foreach($do_members as $member)
        // {
        //     $personal_gpv = $member->personal_gpv;
        //     // $wallet = Wallet::where('user_id', $member->user_id)->first();

        //     // if($wallet && $wallet->pv >= 2500)
        //     if($personal_gpv >= 5000)
        //     {
        //         $qualified_members[] = $member->toArray();
        //         $shares = floor($personal_gpv/5000);
        //         $total_shares = $total_shares + $shares;
        //     }
        // }

        // if($total_shares > 0) $cto_value_per_unit = number_format(($cto_pool/$total_shares), 2, '.', '');
        // else $cto_value_per_unit = 0;


        // foreach($qualified_members as $qmember)
        // {
        //     $wallet = Wallet::where('user_id', $qmember['user_id'])->first();
        //     $cto_unit_share  = floor($personal_gpv/5000);
        //     $cto_value_share = $cto_unit_share * $cto_value_per_unit;

        //     $qualified_member = ActiveDo::where('user_id', $qmember['user_id'])->first();
        //     $qualified_member->cto_unit_share  = $cto_unit_share;
        //     $qualified_member->cto_value_share = $cto_value_share;
        //     $qualified_member->save();
        // }
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

            $children = $root->getImmediateDescendants();

            if(count($children) >= 5)
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
        // $root = Referral::where('user_id', $user_id)->first();

        // $descendants = $root->getDescendants();
        // $personal_gpv = 0;
        // $right        = 0;
        // $qualified    = array();

        // foreach ($descendants as $descendant)
        // {
        //     if($descendant->rank != 'SDO' && $descendant->rgt > $right)
        //     {
        //         $wallet = Wallet::where('user_id', $descendant->user_id)->first();
        //         $personal_gpv = $personal_gpv + (!is_null($wallet) ? $wallet->pv:0) ;
        //         //$qualified[]  = $descendant->toArray();
        //     }
        //     elseif ($descendant->rank == 'SDO')
        //     {
        //         $right = $descendant->rgt;
        //     }
        // }

        // $active_sdo = ActiveSdo::where('user_id', $user_id)->first();
        // $active_sdo->personal_gpv = $personal_gpv;
        // $active_sdo->save();

        // echo '<pre>';
        // print_r($qualified);
        // echo '</pre>';
        // echo '</br>';
        // echo $personal_gpv;

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

     public function getUserRank($id)
    {
        $user = User::find($id);
        $rank = $user->rank->name;

        return $rank;
    }

    public function getUserRankId($id)
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

}
