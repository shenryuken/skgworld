<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\VerifyEmail;

use App\Admin;
use App\User;
use App\Profile;
use App\Product;
use App\Referral;
use App\Role;
use App\Sale;
use App\Wallet;
use App\Store;
use App\Stock;
use App\UserPurchase;
use App\UserBonus;
use App\Invoice;
use App\Rank;
use App\ActiveDo;
use App\ActiveSdo;
use App\Bank;

use Validator;
use Session;
use Carbon\Carbon;
use DB;
use Mail;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        $roles  = Role::all();

        return view('admin.index', compact('admins', 'roles'));
    }

    public function dashboard()
    {
        $user = Auth::guard('admin')->user();
        $user_stats = $this->getUserStats();
        //$sales  = $this->getTotalSales();
        // $total_purchases = $this->totalPurchases();
        // $total_product_purchases = $this->totalProductPurchased();

        $sale_stats = $this->getSaleStats();
        $sales_stock_activity = $this->getSaleStockActivity();
        $last_month_bonus = UserBonus::whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('total_bonus');
 
        $bonus = [
            'total_bonus'     => UserBonus::sum('total_bonus'),
            'last_month_bonus'=> $last_month_bonus,
            'retail_profit'   => UserBonus::sum('retail_profit'),
            'direct_sponsor'  => UserBonus::sum('direct_sponsor'),
            'personal_rebate' => UserBonus::sum('personal_rebate'),
            'do_group_bonus'  => UserBonus::sum('do_group_bonus'),
            'sdo_group_bonus' => UserBonus::sum('sdo_group_bonus'),
            'do_cto_pool'     => UserBonus::sum('do_cto_pool'),
            'sdo_cto_pool'    => UserBonus::sum('sdo_cto_pool'),
            'sdo_sdo'         => UserBonus::sum('sdo_sdo'),
        ];

        list($sales_stock_activity1, $sales_stock_activity2) = array_chunk($sales_stock_activity, ceil(count($sales_stock_activity) / 2));

        return view('admin.dashboard', 
                    compact('user', 'user_stats', 'sale_stats', 'bonus', 'sales_stock_activity1', 'sales_stock_activity2'));

    }

    public function lists()
    {
        $admins = Admin::all();
         $roles  = Role::all();

        return view('admin.lists', compact('admins', 'roles'));
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.edit', compact('admin', 'id'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $request->validate([
            'username'  => 'required|unique:admins,username,'.$id,
            'email'     => 'required|unique:admins,email,'.$id,
            'mobile_no' => 'unique:admins,mobile_no,'.$id,
            'security_code' => 'required',
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){

            $admin->username = $request->username;
            $admin->email    = $request->email;
            $admin->mobile_no= $request->mobile_no;
            $admin->save();

            return back()->with('success', 'Successfully update!');
        }

        return back()->with('fail', 'Failed to update! Please make sure your security code is correct');
    }

    public function registrationMemberForm()
    {
        $ranks  = Rank::all();
        $banks  = Bank::all();
        $products = Product::all();

        return view('admin.register-member', compact('ranks', 'banks', 'products'));
    }

    public function registerMember(Request $request)
    {
        $introducer = $request->introducer;
        $admin = Admin::where('username', $introducer)->first();
        $member= User::where('username', $introducer)->first();
        $rank  = Rank::where('name', $request->rank)->first();

        if (count($admin) == 1){
            $table = 'admins';
        } else {
            $table = 'users';
        } 
        
        //original
        // $request->validate([
        //     'username'  => 'required|unique:users,username',
        //     'password'  => 'required|min:6|confirmed',
        //     'email'     => 'required|unique:users,email',
        //     'mobile_no' => 'required',
        //     'rank_id'   => '',
        //     'security_code' => 'required',
        // ]);

        $request->validate([
            'country'   => 'required',
            'username'  => 'required|unique:users,username',
            'password'  => 'required|min:6|confirmed',
            'type'      => 'required',
            'name'      => 'required',
            'dob'       => 'required',
            'gender'    => 'required',
            'marital_status'    => 'required',
            'race'              => 'required',
            'id_type'           => 'required',
            'id_no'             => 'required',
            'id_pic'            => 'image|mimes:jpeg,bmp,png|size:2000',
            'introducer'        => 'required|exists:'.$table.',username',
            'mobile_no'         => 'required',
            'email'             => 'required',
            'street'            => 'required',
            'city'              => 'required',
            'postcode'          => 'required',
            'state'             => 'required',
            'bank'              => 'required',
            'account_no'        => 'required',
            'acc_holder_name'   => 'required',
            'check1'            => '',
            'account_type'      => 'required',
            'beneficiary_name'  => '',
            'relationship'      => 'required_with:beneficiary_name',
            'beneficiary_address'   => 'required_with:beneficiary_name',
            'beneficiary_mobile_no' => 'required_with:beneficiary_name, beneficiary_address',
            'rank_id'           => '',
            'security_code'     => 'required',
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode))
        {
            $user = new User;
            $user->username   = $request->username;
            $user->password   = bcrypt($request->password);
            $user->security_code = bcrypt($request->password); 
            $user->email      = $request->email;
            $user->email_token   = Password::getRepository()->createNewToken();
            $user->mobile_no  = $request->mobile_no;
            $user->introducer = $request->introducer;
            $user->rank_id    = $rank->id;
            //$user->save();

            $profile = new Profile;     
            $profile->full_name = $request->name;
            $profile->dob       = $request->dob;
            $profile->gender    = $request->gender;
            $profile->marital_status = $request->marital_status;
            $profile->id_type   = $request->id_type;
            $profile->id_no     = $request->id_no;
            $profile->id_pic    = $request->id_pic;
            $profile->street    = $request->street;
            $profile->city      = $request->city;
            $profile->postcode  = $request->postcode;
            $profile->state     = $request->state;
            $profile->country   = $request->country;
            $profile->contact_no    = $request->mobile_no;
            //$user->profile()->save($profile);

            DB::transaction(function() use ($user, $profile) {
                $user->save();
                $user->profile()->save($profile);
            });

            //profile, bank,

            $user->rank()->associate($rank);
            $user->save();

           
            if ($user) {
                if($rank->id == 4)
                {
                    $active_do = new ActiveDo;
                    $active_do->user_id = $user->id;
                    $active_do->rank    = $request->rank;
                    $active_do->save();

                    $active_sdo = ActiveSdo::where('user_id', $user->id)->first();

                    if($active_sdo)
                    {
                       $active_sdo->delete();
                    }
                } 
                elseif($rank->id < 4 )
                {
                    $active_do = ActiveDo::where('user_id', $user->id)->first();
                    $active_sdo = ActiveSdo::where('user_id', $user->id)->first();
                    if($active_do)
                    {
                       $active_do->delete();  
                    }

                    if($active_sdo)
                    {
                        $active_sdo->delete();
                    }
                }
                
                elseif($rank->id == 5) 
                {
                    $active_do = new ActiveDo;
                    $active_do->user_id = $user->id;
                    $active_do->rank    = $request->rank;
                    $active_do->save();

                    $active_sdo = new ActiveSdo;
                    $active_sdo->user_id = $user->id;
                    $active_sdo->rank    = $request->rank;
                    $active_sdo->save();

                    // $active_do = ActiveDo::where('user_id', $user->id)->first();
                    // if($active_do)
                    // {
                    //    $active_do->delete();
                    // }
                }
            }
            

            Mail::to($user)->send(new VerifyEmail($user));

            if($admin)
            {
                $introducer = Admin::where('username', $request->introducer)->first();
                $introducer->total_referral = $introducer->total_referral + 1;
                $introducer->save();
            } else {
                $introducer = User::where('username', $request->introducer)->first();
                $introducer->total_referral = $introducer->total_referral + 1;
                $introducer->save();
            }

            //count insert user referrall hierarchy
            $referral = Referral::where('username',$introducer->username)->first();
            
            if(!is_null($referral))
            {
                $node = Referral::create(['user_id' => $user->id, 'username' => $user->username, 'rank' => $rank->code_name]);
                $node->makeChildOf($referral);
            } 
            else 
            {
                $root = Referral::create(['user_id' => $user->id, 'username' => $user->username, 'rank' => $rank->code_name]);
            }

            //return redirect('admin/register-member')->with('success', 'Successfully register this account:'.$user->email);
            return view('admin.firstTimePurchaseRegistration', compact('user'));
        }

        return back()->withInput()
                     ->with('fail', 'Failed to register! Please Check Your Security Code Is Correct Or Try Again. ');
    }

    public function firstTimePurchaseRegistration()
    {
        $products = Product::all();

        return view('admin.firstTimeMall', compact('products'));
    }

    public function registrationStaffForm()
    {
        $roles = Role::all();
        return view('admin.register-staff', compact('roles'));
    }

    public function registerStaff(Request $request)
    {
        $request->validate([
                'username'  => 'required|unique:admins,username',
                'password'  => 'required|min:6|confirmed',
                'email'     => 'required|unique:admins,email',
                'mobile_no' => 'required',
                'role'      => 'required',
            ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){
            $admin = new Admin;
            $admin->username   = $request->username;
            $admin->password   = bcrypt($request->password);
            $admin->email      = $request->email;
            $admin->mobile_no  = $request->mobile_no;
            $admin->save();

            $admin->assignRole($request->role);

            return back()->with('success', 'Successfully register staff: '. $admin->username);
        }

        return back()->with('fail', 'Failed to register staff: '.$request->username . '.Please make sure your security code is correct or try again');
    }

    public function changeEmail()
    {
        return view('admin.changeEmail');
    }

    public function postChangeEmail(Request $request)
    {
        $old_email  = $request->email;
        $new_email  = $request->new_email;
        $id         = $request->user_id; 

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('admin/changeEmail')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $admin = Admin::find($id);
            $admin->email = $request->new_email;
            $admin->save();

            //session(['success' => 'Successfully change email from ' . $old_email .' to '. $new_email]);
            Session::flash('success', 'Successfully change email from ' . $old_email .' to '. $new_email);

            return redirect('admin/changeEmail');
        }
    }

    public function profile($id)
    {
        $user       = Admin::find($id);
        $profile    = $user->profile;
        //$profile    = Profile::where('profileable_id', $id)->where('profileable_type', 'User')->first();

        //var_dump($profile);

        return view('admin.profile', compact('user', 'profile'));
    }

    public function createProfile()
    {
        return view('admin.create-profile');
    }

    public function saveProfile(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->user()->id);
       
        $request->validate([
            'full_name' => 'required',
            'icno'      => 'required',
            'street'    => 'required',
            'city'      => 'required',
            'postcode'  => 'required',
            'state'     => 'required',
            'country'   => 'required',
            'contact_no' => 'required',
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode))
        {
            $profile = new Profile;     
            $profile->full_name = $request->full_name;
            $profile->icno      = $request->icno;
            $profile->street    = $request->street;
            $profile->city      = $request->city;
            $profile->postcode  = $request->postcode;
            $profile->state     = $request->state;
            $profile->country   = $request->country;
            $profile->contact_no    = $request->contact_no;
            $profile->contact_no2   = $request->contact_no2;
            $admin->profile()->save($profile);

            return back()->with('success', 'Successfully update your profile!');
        }       
            
        return back()->with('fail', 'Fail to update your profile! Please make sure your security code is correct or try again'); 
    }

    public function getUserStats()
    {
        $date = Carbon::now();
        $startDate = Carbon::now()->startOfWeek()->format('Y/m/d');
        $endDate = $date = Carbon::now()->endOfWeek()->format('Y/m/d');

        $users                   = User::count();
        $customers               = User::where('rank_id',1)->count();
        $loyal_customer          = User::where('rank_id', 2)->count();
        $marketing_officer       = User::where('rank_id', 3)->count();
        $district_officer        = User::where('rank_id', 4)->count();
        $senior_district_officer = User::where('rank_id', 5)->count();
        $today                   = User::whereDate('created_at', $date )->count();
        $this_week               = User::whereBetween('created_at',[$startDate, $endDate])->count();
        $this_month              = User::whereMonth('created_at',Carbon::now()->format('n'))->count();

        $users = [
            'ALL'=> $users,
            'C'  => $customers,
            'LC' => $loyal_customer,
            'MO' => $marketing_officer,
            'DO' => $district_officer,
            'SDO'=> $senior_district_officer,
            'today' => $today,
            'this_week' => $this_week,
            'this_month' => $this_month
        ];

        return $users;
    }

    public function getSaleStats()
    {
        $year = Carbon::now()->year;
        $startDate = Carbon::now()->startOfWeek()->format('Y/m/d');
        $endDate = $date = Carbon::now()->endOfWeek()->format('Y/m/d');
        
        $total_sales           = Sale::where('year', $year)->sum('total_sale');
        $total_pv              = Sale::where('year', $year)->sum('total_pv');
        $today_sales           = Invoice::where('status', 'Fully Paid')->whereDate('created_at', Carbon::today())->sum('total');
        $this_week_sales       = Invoice::whereBetween('created_at',[$startDate, $endDate])->sum('total');
        $this_month_sales      = Sale::where('month', Carbon::today()->month)
                                        ->where('year', Carbon::today()->year)
                                        ->first(['total_sale', 'total_pv']);

        $sale_stats = [
            'total_sales' => $total_sales,
            'total_pv'    => $total_pv,
            'today'       => $today_sales,
            'this_week'   => $this_week_sales,
            'this_month'  => $this_month_sales
        ];

        return $sale_stats;
    }

    public function totalPurchases()
    {
        return $total_purchases = Wallet::sum('purchased');
    }

    public function totalProductPurchased()
    {
        $store = Store::count();
        $userPurchases = UserPurchase::count();

        return $store + $userPurchases;
    }

    public function getTotalSales()
    {
       
        $year = Carbon::now()->year;
        // $sales = Sale::groupBy('year')
        //                     ->selectRaw('sum(total_sale) as total_sale, sum(total_pv) as total_pv, count(*) as months')->get();
        $sales = Sale::where('year', $year)->sum('total_sale');
        

        return $sales;
    }

    public function getSaleStockActivity()
    {
        $products = Product::all();

        $stats = array();
        $data = array();

        foreach ($products as $product) {
            $data = [
             'y'       => $product->name,
             'Sold'    => Stock::where('product_id', $product->id)->where('status', 'Sold')->count(),
             'Stock'   => $product->stocks->count(),
             'Returned'=> $product->returnGoods->count()
            ];

            $stats[] = $data;
        }

        return $stats;
    }

    //Role
    public function assignRole()
    {
        $roles = Role::all();

        return view('admin.assign-role', compact('roles'));
    }

    public function postAssignRole(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'security_code' => 'required',
        ]);

        $admin = Admin::find($request->id);
        
        $admin->assignRole($request->role);

        return redirect()->back()
                            ->with('success','Role Assign successfully');
    }

    public function revokeRole($id)
    {
        $admin = Admin::find($id);
        $roles = $admin->roles;
        return view('admin.revoke-role', compact('admin', 'roles'))->with('success','Role Revoke successfully');
    }

    public function postRevokeRole(Request $request)
    {
        $request->validate([
            'role' => 'required',
        ]);

        $admin = Admin::find($request->user_id);
        $role  = $request->role;

        $admin->revokeRole($role);

        return back();
    }

    //End Role
}