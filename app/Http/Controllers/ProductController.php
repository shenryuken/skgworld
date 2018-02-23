<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Product;

use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'name'            => 'required',
          'code'            => 'required',
          'wm_price'        => 'required|numeric',
          'em_price'        => 'required|numeric',
          'pv'              => 'required',
          'description'     => 'required',
          'security_code'   => 'required'
        ]);
        
        $hashedCode = Auth::guard('admin')->user()->security_code;
        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){

            Product::create($request->except('_token', 'security_code'));
            return back()->with('success', 'Product has been added');
        }

         return back()->with('fail', 'Failed to create this product: '.$request->name.'! Please make sure your security code is correct or try again');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'name'            => 'required',
          'code'            => 'required',
          'wm_price'        => 'required|numeric',
          'em_price'        => 'required|numeric',
          'pv'              => 'required',
          'description'     => 'required',
          'security_code'   => 'required'
        ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){
            $product = Product::find($id);
            $product->name          = $request->get('name');
            $product->code          = $request->get('code');
            $product->wm_price      = $request->get('wm_price');
            $product->em_price      = $request->get('em_price');
            $product->pv            = $request->get('pv');
            $product->description   = $request->get('description');
            $product->save();
            
            return back()->with('success','Product:'.$product->name .' has been updated');
        }

        return back()->with('fail', 'Failed to update this product! Please make sure your security code is correct or try again');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('products')->with('success','Product has been  deleted');
    }
}
