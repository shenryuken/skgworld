<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Account;

class AccountController extends Controller
{
    public function index()
    {
    	$accounts = Account::all();

    	return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
    	return view('accounts.create');
    }

    public function edit(Request $request, $id)
    {
    	$account = Account::find($id);

    	return view('accounts.edit', compact('account'));
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'holder_name'   => 'required',
            'acc_no' 		=> 'required',
            'bank_id' 		=> 'required',
            'branch' 		=> 'required',
            'user_id'       => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('accounts/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else { 
        	$account = new Account; 	
        	$account->user_id 			= $request->user_id;
	        $account->holder_name 		= $request->holder_name;
	        $account->acc_no     		= $request->acc_no;
	        $account->bank_id 	 		= $request->bank_id;
	        $account->branch     		= $request->branch;
	        $account->save();

	        return redirect('account');
        	
        }	
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'holder_name'   => 'required',
            'acc_no' 		=> 'required',
            'bank_id' 		=> 'required',
            'branch' 		=> 'required',
        ]);

        if ($validator->fails()) {
            return redirect('accounts/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        else { 
        	$account = Account::find($id); 	
	        $account->holder_name 		= $request->holder_name;
	        $account->acc_no     		= $request->acc_no;
	        $account->bank_id 	 		= $request->bank_id;
	        $account->branch     		= $request->branch;
	        $account->save();

	        return redirect('account');
        }	
    }
}
