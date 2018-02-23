<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;

use App\Bank;

class BankController extends Controller
{
    public function index()
    {
    	$banks = Bank::all();

        return view('banks.index', compact('banks'));
    }

    public function create()
    {
    	return view('banks.create');
    }

    public function edit($id)
    {
        $bank = Bank::find($id);

        $banks = Bank::all();

        return view('banks.edit', compact('bank', 'banks'));
    }

    public function store(Request $request)
    {
    	$request->validate([
            'bank_name'     => 'required',
            'code' 			=> 'required',
            'status'        => 'required',
            'origin_country'=> 'required_if:status,foreign',
            'security_code' => 'required'
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){

	        $bank = new Bank;
	        $bank->name 	= $request->bank_name;
	        $bank->code  	= $request->code;
	        $bank->status   = $request->status;
	        $bank->origin_country = $request->origin_country;
	        $bank->save();

	        return back()->with('success', 'Successfully saved!');
	    }

	    return back()->with('fail', 'Failed to save! Please make sure your security code is correct');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name'     => 'required',
            'code'          => 'required',
            'status'        => 'required',
            'origin_country'=> 'required_if:status,foreign',
            'security_code' => 'required'
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){

            $bank = Bank::find($id);
            $bank->name     = $request->bank_name;
            $bank->code     = $request->code;
            $bank->status   = $request->status;
            $bank->origin_country = $request->origin_country;
            $bank->save();

            return back()->with('success', 'Successfully updated!');
        }

        return back()->with('fail', 'Failed to update! Please make sure your security code is correct');
    }
}
