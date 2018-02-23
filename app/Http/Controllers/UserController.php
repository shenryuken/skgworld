<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Baum\Node;
use Illuminate\Support\Facades\Password;
use Mail;
use App\Mail\VerifyEmail;

use App\User;
use App\Admin;
use App\Profile;
use App\Rank;
use App\Referral;
use App\ActiveDo;
use App\ActiveSdo;
use App\Wallet;
use App\AgentPayment;

use Validator;
use Session;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth',['except' => ['lists']]);
        //$this->middleware('auth:admin');
    }

    public function index()
    {
        $members = User::all();
        $ranks   = Rank::all();

        return view('user.index', compact('members', 'ranks'));
    }

    public function lists()
    {
        $members = User::all();
        $ranks   = Rank::all();

        return view('user.lists', compact('members', 'ranks'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'     => 'required|email|exists:users,email|max:255',
            'new_email' => 'required|email|max:255|unique:users,email|confirmed',
        ]);
    }

    public function dashboard()
    {
        $user       = Auth::user();
        $wallet     = $user->wallet;
        $total_sales = AgentPayment::where('agent_id', $user->id)->sum('amount');
        $uplines     = Referral::where('user_id', $user->id)->first()->getAncestors();
        $dowlines    = Referral::where('user_id', $user->id)->first()->getImmediateDescendants();
     //    $evoucher   = $user->wallet ? $user->wallet->evoucher: 0;
     //    $root       = Referral::where('user_id', $user->id)->first();
     //    $referrals  = $root->getDescendants();
     //    $direct_sponsor = $root->getImmediateDescendants();
    	// return view('user.dashboard', compact('evoucher', 'referrals','direct_sponsor'));
    	return view('user.dashboard', compact('user', 'wallet', 'total_sales', 'uplines', 'dowlines'));
    }

    public function registrationMemberForm()
    {
        return View('user.register-member');
    }

    public function registerMember(Request $request)
    {
        $introducer = $request->introducer;
        $admin   = Admin::where('username', $introducer)->first();
        $member  = User::where('username', $introducer)->first();

        if (count($admin) == 1){
            $table = 'admins';
        } else {
            $table = 'users';
        } 

        $request->validate([
                'username'  => 'required|unique:users,username',
                'password'  => 'required|min:6|confirmed',
                'email'     => 'required|unique:users,email',
                'mobile_no' => 'required',
                'introducer'=> 'required|exists:'.$table.',username'
            ]);

        $hashedCode = Auth::user()->security_code;

        if(Auth::check() && Hash::check($request->security_code, $hashedCode)){

            $user = new User;
            $user->username      = $request->username;
            $user->password      = bcrypt($request->password);
            $user->security_code = bcrypt($request->password); 
            $user->email         = $request->email;
            $user->email_token   = Password::getRepository()->createNewToken();
            $user->mobile_no     = $request->mobile_no;
            $user->introducer    = $request->introducer;
            $user->rank_id       = 1;
            $user->save();

            Mail::to($user)->send(new VerifyEmail($user));

            //$user->assignLevel('Customer');
            $rank = Rank::where('name', 'Customer')->first();

            $user->rank()->associate($rank);
            $user->save();

            $introducer = User::where('username', $request->introducer)->first();
            $introducer->total_referral = $introducer->total_referral + 1;
            $introducer->save();

            //count direct sponsor bonus

            $referral = Referral::where('username',$introducer->username)->first();
            
            if(!is_null($referral))
            {
                $node = Referral::create(['user_id' => $user->id, 'username' => $user->username, 'rank' => 'C']);
                $node->makeChildOf($referral);
            } 
            else 
            {
                $root = Referral::create(['user_id' => $user->id, 'username' => $user->username, 'rank' => 'C']);
            }

            return redirect('user/register-member')->with('success', 'Successfully register this account:'.$user->email);
        }
        
        return back()->with('fail', 'Failed to register! Please Check Your Security Code Is Correct Or Try Again. ');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'username'  => 'required|unique:users,username,'.$id,
                'email'     => 'required|unique:users,email,'.$id,
                'mobile_no' => 'required',
            ]);

        if($validator->fails()){
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $user = User::find($id);
            $user->username = $request->username;
            $user->email    = $request->email;
            $user->mobile_no= $request->mobile_no;
            $user->save();

            //return redirect('user/lists');
            return redirect()->back()->with('success','User update successfully');
        }
    }

    public function confirmEmail($token)
    {
        return view('emails.confirm-email', compact('token'));
    }

    public function postConfirmEmail(Request $request)
    {
        $user = User::where('email_token', $request->email_token)->first();

        if(!is_null($user))
        {
            $user->verified    = 1;
            $user->email_token = 'NULL';
            $user->save();

            return back()->with('success', 'Successfully Confirm Your Email:'.$user->email);
        } 
        else
        {
            return back()->with('failed', 'The activation link is not found.');
        } 

    }

    public function changeEmail()
    {
        return view('user.change-email');
    }

    public function postChangeEmail(Request $request)
    {
        $old_email  = $request->email;
        $new_email  = $request->new_email;
        $id         = $request->user_id; 

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('change-email')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $user = User::find($id);
            $user->email = $request->new_email;
            $user->save();

            //session(['success' => 'Successfully change email from ' . $old_email .' to '. $new_email]);
            Session::flash('success', 'Successfully change email from ' . $old_email .' to '. $new_email);

            return redirect('change-email');
        }
    }

    // public function createProfile()
    // {
    // 	return view('user.create_profile');
    // }

    // public function profile($id)
    // {
    // 	$user 		= User::find($id);
    // 	$profile 	= $user->profile;
    //     //$profile    = Profile::where('profileable_id', $id)->where('profileable_type', 'User')->first();

    // 	//var_dump($profile);

    // 	return view('user.profile', compact('user', 'profile'));
    // }

    // public function editProfile($id)
    // {
    // 	$user 		= User::find($id);
    // 	$profile 	= $user->profile;

    // 	return view('user.edit_profile', compact('profile'));
    // }

    // public function saveProfile(Request $request)
    // {

    // 	$id = $request->user_id;
    // 	$user 		= User::find($id);

    // 	$validator = Validator::make($request->all(), [
    //         'full_name' => 'required',
    //         'icno' 		=> 'required',
    //         'street' 	=> 'required',
    //         'city' 		=> 'required',
    //         'postcode' 	=> 'required',
    //         'state' 	=> 'required',
    //         'country' 	=> 'required',
    //         'contact_no' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect('user/create_profile')
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }
    //     else { 
    //     	$profile = new Profile; 	
	   //      $profile->full_name = $request->full_name;
	   //      $profile->icno 		= $request->icno;
	   //      $profile->street 	= $request->street;
	   //      $profile->city 		= $request->city;
	   //      $profile->postcode 	= $request->postcode;
	   //      $profile->state 	= $request->state;
	   //      $profile->country 	= $request->country;
	   //      $profile->contact_no 	= $request->contact_no;
	   //      $profile->contact_no2 	= $request->contact_no2;
	   //      $user->profile()->save($profile);

	   //      return redirect('user/profile/'.$id);
        	
    //     }	
    // }

    // public function updateProfile(Request $request, $id)
    // {
    // 	$validator = Validator::make($request->all(), [
    //         'full_name' => 'required',
    //         'icno' 		=> 'required',
    //         'street' 	=> 'required',
    //         'city' 		=> 'required',
    //         'postcode' 	=> 'required',
    //         'state' 	=> 'required',
    //         'country' 	=> 'required',
    //         'contact_no' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect('user/profile/'.$id.'/edit')
    //                     ->withErrors($validator)
    //                     ->withInput();
    //     }
    //     else { 
    //     	$profile = Profile::find($id);
	   //      $profile->full_name = $request->full_name;
	   //      $profile->icno 		= $request->icno;
	   //      $profile->street 	= $request->street;
	   //      $profile->city 		= $request->city;
	   //      $profile->postcode 	= $request->postcode;
	   //      $profile->state 	= $request->state;
	   //      $profile->country 	= $request->country;
	   //      $profile->contact_no 	= $request->contact_no;
	   //      $profile->contact_no2 	= $request->contact_no2;
	   //      $profile->save();

	   //      return redirect('user/profile/'.$profile->id);
    //     }	
    // }

    public function updateRank($id)
    {
        $ranks = Rank::all();
        $user  = User::find($id);
        
        return view('user.update-rank', compact('user', 'ranks'));
    }

    public function postAssignRank(Request $request)
    {
        $user = User::find($request->user_id);
        $rank = Rank::where('name', $request->rank)->first();

        $user->rank()->associate($rank);
        $user->save();

        $referral = Referral::where('user_id', $user->id)->first();
        $referral->rank = $rank->code_name;
        $referral->save();

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
        
        if ($rank->id == 5) 
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
        /*elseif ($rank->id < 5) {
            $active_sdo = ActiveSdo::where('user_id', $user->id)->first();
            if($active_sdo)
            {
               $active_sdo->delete();
            }
        }*/

        return back()->with('success','User update rank successfully');;
    }

    public function mykadStatusIndex()
    {
        $users = User::all();

        $count_profile = Profile::where('profileable_type', 'App\User')->count();
        $count_user    = $users->count();

        $pending = Profile::where('status_ic', 'Pending')->where('profileable_type', 'App\User')->count();
        $waiting_approval = Profile::where('status_ic', 'Waiting Approval')->count();
        $not_valid        = Profile::where('status_ic', 'Not Valid')->count();
        $approved         = Profile::where('status_ic', 'Approved')->count();

        $mykad_status = [
            'pending' => $pending,
            'not_update' => $count_user - $count_profile,
            'waiting_approval' => $waiting_approval,
            'not_valid' => $not_valid,
            'approved'  => $approved
        ];

        return view('user.mykad-status-index', compact('users', 'mykad_status', 'count_user'));
    }

    public function showMykadStatus($id)
    {
        $profile = Profile::find($id);
        
        if(!is_null($profile))
        {
            return view('user.show-mykad-status', compact('profile'));
        }

        return back()->with('fail', 'There is no profile found for '.$user->username);
    }

    public function updateMykadStatus(Request $request)
    {
        //
    }
}
