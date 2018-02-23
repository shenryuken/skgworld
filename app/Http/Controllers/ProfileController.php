<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;


use App\Profile;
use App\Admin;
use App\User;

use Validator;
use Session;
use Carbon\Carbon;
use DB;
use Image;


class ProfileController extends Controller
{
    public function create()
    {
    	return view('profiles.create');
    }

    public function edit($id)
    {
    	$profile = Profile::find($id);
    	return view('profiles.edit', compact('profile'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    		'_token'            => 'required',
    		'full_name' 		=> 'required',
    		'icno'  	 		=> 'required',
    		'street'    		=> 'required',
    		'postcode'   		=> 'required',
    		'city' 		 		=> 'required',
    		'state'      		=> 'required',
    		'country'    		=> 'required',
    		'contact_no' 		=> 'required',
    		'contact_no2'		=> '',
    		'profileable_id'    => 'required',
    		'profileable_type' 	=> 'required'
    	]);

        if(Auth::check()){
            $hashedCode = Auth::user()->security_code;
        }
        elseif(Auth::guard('admin')->check()){
            $hashedCode = Auth::guard('admin')->user()->security_code;
        }
        
        if(Hash::check($request->security_code, $hashedCode)){
            $profile = Profile::create($request->except('_token', 'security_code'));
            return back()->with('success', 'Successfully Created Profile!');
        }
        
        return back()->with('fail', 'Failed to create profile! Please Check Your Security Code Is Correct Or Try Again. ');	
    }

    public function update(Request $request, $id)
    {
    	$profile = Profile::find($id);

    	$request->validate([
    		'full_name' 		=> 'required',
    		'icno'  	 		=> 'required',
    		'street'    		=> 'required',
    		'postcode'   		=> 'required',
    		'city' 		 		=> 'required',
    		'state'      		=> 'required',
    		'country'    		=> 'required',
    		'contact_no' 		=> 'required',
    		'contact_no2'		=> '',
    	]);

        if(Auth::check()){
            $hashedCode = Auth::user()->security_code;
        }
        elseif(Auth::guard('admin')->check()){
            $hashedCode = Auth::guard('admin')->user()->security_code;
        }

        if(Hash::check($request->security_code, $hashedCode)){
            $profile->full_name = $request->full_name;
            $profile->icno      = $request->icno;
            $profile->street    = $request->street;
            $profile->postcode  = $request->postcode;
            $profile->city      = $request->city;
            $profile->state     = $request->state;
            $profile->country   = $request->country;
            $profile->contact_no= $request->contact_no;
            $profile->contact_no2= $request->contact_no2;
            $profile->save();

            return back()->with('success', $profile->profileable->username .' you are successfully updated your profile!');
        }

    	return back()->with('fail', 'Failed to update profile! Please Check Your Security Code Is Correct Or Try Again. ');   
    }

    public function show($id)
    {
    	$user = User::find($id);
    	$profile = $user->profile;
    	$guard   = 'web';

    	return view('profiles.show', compact('profile', 'guard'));
    }

    public function showAdmin($id)
    {
    	$admin = Admin::find($id);
    	$profile = $admin->profile;
    	$guard   = 'admin';

    	return view('profiles.show', compact('profile', 'guard'));
    }

    public function uploadAvatar()
    {
        $user = Auth::user();
        return view('profiles.upload-avatar', compact('user'));    }

    public function postUploadAvatar()
    {
        $request->validate([

            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(200, 200)->save( public_path('/app/avatars/' . $filename ) );

        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();
        
        return back()
                ->with('success','You have successfully upload image.')
                ->with('image',$filename);
    
    }

    public function uploadIc()
    {
        $user = Auth::user();
        return view('profiles.upload-ic', compact('user'));
    }

    public function postUploadIc(Request $request)
    {
        $request->validate([

            'ic_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if(Auth::check()){
            $hashedCode = Auth::user()->security_code;
        }

        if(Hash::check($request->security_code, $hashedCode))
        {
            $ic_image  = $request->file('ic_image');
            $filename  = time() . '.' . $ic_image->getClientOriginalExtension();
            $saveImage = Image::make($ic_image)->resize(400, 300)->save( public_path('/app/mykad/' . $filename ) );

            $user = Auth::user();
            // $user->ic_image = $filename;
            // $user->save();
            if($saveImage){

                $profile = $user->profile;
                $profile->ic_image   = $filename;
                $profile->status_ic  = 'Waiting Approval';
                $profile->save();

                return back()
                    ->with('success','You have successfully upload image.')
                    ->with('image',$filename);
            }
        }
  
        return back()
                ->with('fail','You Mykad failed to upload. Please check your image not exceed 2MB size');
        
    }

    public function icStatusIndex()
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

        return view('profiles.ic-status-index', compact('users', 'mykad_status', 'count_user'));
    }

    public function showIcStatus($id)
    {
        $profile = Profile::find($id);
        
        if(!is_null($profile))
        {
            return view('profiles.show-ic', compact('profile'));
        }

        return back()->with('fail', 'There is no profile found for '.$user->username);
    }

    public function updateIcStatus(Request $request)
    {
        $status = 'Pending';

        switch ($request->status) {
            case 'Approve':
                $status = 'Approved';
                break;
            case 'Reject':
                $status = 'Not Valid';
                break;
            default:
                $status = 'Pending';
                break;
        }

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){
            $profile = Profile::find($request->id);
            $profile->status_ic = $status;
            $profile->save();

            return redirect()->back()->with('success', 'MyKad\Passport successfully validate: '.$request->status);
        }
            

        return back()->with('fail', 'Action Failed! Please make sure your security code is correct.');
        
    }

}
