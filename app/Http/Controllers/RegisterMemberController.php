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
use App\Package;
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
use App\NewUser;
use App\NewProfile;

use Validator;
use Session;
use Cart;
use Carbon\Carbon;
use DB;
use Mail;

class RegisterMemberController extends Controller
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

    public function registrationMemberForm()
    {
        $ranks  = Rank::all();
        $banks  = Bank::all();
        $products = Product::all();
        $packages = Package::all();

        return view('admin.register-member', compact('ranks', 'banks', 'products', 'packages'));
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
            $user = new NewUser;
            $user->username   = $request->username;
            $user->password   = bcrypt($request->password);
            $user->security_code = bcrypt($request->password); 
            $user->email      = $request->email;
            $user->email_token   = Password::getRepository()->createNewToken();
            $user->mobile_no  = $request->mobile_no;
            $user->introducer = $request->introducer;
            $user->rank_id    = $rank->id;
            $user->save();
            Session::put('uid',$user->id);

            $profile = new NewProfile;     
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
            $user->newprofile()->save($profile);
            // Session::put('profile',$profile);

            // $pids = $request->pid;
            // $chck = 0;

            // foreach($pids as $pid)
            // {
            // 	$product = Product::find($pid);
            // 	Cart::add($product->id, 'Product: '.$product->name, $quantity, $product->wm_price);
            // }

            //return view('admin.firstTimePurchaseRegistration', compact('user'));
            return redirect()->route('firstTimePurchaseRegistration', compact('user'));
        }
        // session()->forget('user');
        // session()->forget('profile');

        return back()->withInput()
                     ->with('fail', 'Failed to register! Please Check Your Security Code Is Correct Or Try Again. ');
    }

    public function firstTimePurchaseRegistration()
    {
        $products = Product::all();
        $packages = Package::all();

        return view('admin.firstTimePurchaseRegistration', compact('products', 'packages'));
    }
            
}
