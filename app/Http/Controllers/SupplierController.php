<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Personnel;

use Validator;

class SupplierController extends Controller
{
     public function index()
    {
    	$suppliers = Supplier::all();

    	return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
    	return view('suppliers.create');
    }

    public function getPersonnels($id)
    {
        $supplier 		= Supplier::find($id);
        $company_name 	= $supplier->company_name;
        $personnels 	= $supplier->personnels;

        return view('suppliers.personnels-list', compact(['company_name','personnels', 'supplier']));
      
    }

    public function addPersonnel($id)
    {
        $company = Supplier::find($id);
       
        return view('supplier.addPersonnel', compact(['company']));
    }

    public function postAddPersonnel(Request $request)
    {
        $id = $request->supplier_id;
        $supplier = Supplier::find($id);

        $validator = Validator::make($request->all(), [
            'full_name'     => 'required',
            'position'      => 'required',
            'department'    => 'required',
            'mobile_no'     => 'required',
            'phone_no'      => 'required',
            'email'         => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('suppliers/'.$id.'/addPersonnel')
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $contact = new Personnel;
            $contact->name          = $request->full_name;
            $contact->position      = $request->position;
            $contact->department    = $request->department;
            $contact->mobile_no     = $request->mobile_no;
            $contact->phone_no      = $request->phone_no;
            $contact->ext_no        = $request->ext_no;
            $contact->email         = $request->email;
            $supplier->personnels()->save($contact);

            return redirect('suppliers');
        }
    }

    public function updatePersonnel(Request $request, $id)
    {
        // $id = $request->supplier_id;
        // $supplier = Supplier::find($id);

        $validator = Validator::make($request->all(), [
            'full_name'     => 'required',
            'position'      => 'required',
            'department'    => 'required',
            'mobile_no'     => 'required',
            'phone_no'      => 'required',
            'email'         => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('suppliers/'.$id.'/addPersonnel')
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $contact = Personnel::find($id);
            $contact->name          = $request->full_name;
            $contact->position      = $request->position;
            $contact->department    = $request->department;
            $contact->mobile_no     = $request->mobile_no;
            $contact->phone_no      = $request->phone_no;
            $contact->ext_no        = $request->ext_no;
            $contact->email         = $request->email;
            $contact->save();

            return redirect('suppliers');
        }
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'company_name' 		=> 'required|unique:suppliers,company_name',
            'street' 		    => 'required',
            'postcode'      	=> 'required',
            'city'          	=> 'required',
            'state'          	=> 'required',
            'country'       	=> 'required',
            'telephone_no' 		=> 'required',
            'fax_no' 	      	=> 'required',
            'email'			    => 'required|unique:suppliers,email',
        ]);

        if ($validator->fails()) {
            return redirect('suppliers/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else { 

        	$supplier = new Supplier; 	
	        $supplier->company_name = $request->company_name;
	        $supplier->street 	    = $request->street;
	        $supplier->postcode 	= $request->postcode;
	        $supplier->city 	    = $request->city;
	        $supplier->state 	    = $request->state;
	        $supplier->country 	    = $request->country;
	        $supplier->telephone_no = $request->telephone_no;
	        $supplier->fax_no 		= $request->fax_no;
	        $supplier->email 		= $request->email;
	      	$supplier->save();

	        return redirect('suppliers');
        }	
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(), [
            'company_name'      => 'required',
            'street'            => 'required',
            'postcode'          => 'required',
            'city'              => 'required',
            'state'             => 'required',
            'country'           => 'required',
            'telephone_no'      => 'required',
            'fax_no'            => 'required',
            'email'             => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('suppliers/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        else { 

            $supplier = Supplier::find($id);   
            $supplier->company_name = $request->company_name;
            $supplier->street       = $request->street;
            $supplier->postcode     = $request->postcode;
            $supplier->city         = $request->city;
            $supplier->state        = $request->state;
            $supplier->country      = $request->country;
            $supplier->telephone_no = $request->telephone_no;
            $supplier->fax_no       = $request->fax_no;
            $supplier->email        = $request->email;
            $supplier->save();

            return redirect('suppliers');
        }   
    }
}
