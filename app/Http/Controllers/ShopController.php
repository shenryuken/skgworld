<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Product;
use App\Package;
use App\Referral;
use App\Wallet;
use App\Store;

use Validator;
use Session;
use Cart;

class ShopController extends Controller
{
    public function skgMall()
    {
    	$products = Product::all();

    	return view('shops.skg-mall', compact('products'));
    }

    public function agentsStoreList()
    {
    	$id = Auth::user()->id;

    	$my = Referral::where('user_id', $id)->first();

    	$agents = $my->getAncestors();

    	$qualified_agents = array();
    	$count = 0;
    	
    	foreach ($agents as $agent) 
    	{
    		$wallet  = Wallet::where('user_id', $agent->user_id)->first();
            $rank_id = $agent->user->rank_id;
    		
    		//if(($rank_id > 2 && $count < 5) && ($wallet && $wallet->current_pv >= 0))//original
            if(($rank_id > 2 && $count < 5))//for tresting
    		{
    			$qualified_agents[] = $agent;
    			$count++; 
    		}

    		elseif($count == 5) break;
    	}

        return view('shops.agents-store-list', compact('qualified_agents'));
        // echo '<pre>';
        // var_dump($agents->toArray());
        // echo '</pre>';
    }

    public function agentStore($id)
    {
        $user     = User::find($id);
        $products = Store::where('user_id', $id)->groupBy('product_id')->get();

        return view('shops.agent-store', compact('user', 'products'));
    }

    //Cart
    public function addToCart(Request $request)
    {
        $itemType = $request->itemType;
        $quantity = $request->quantity;

        if($itemType == 'product')
        {
            $product = Product::find($request->id);
            $addtocart = Cart::add($product->id, 'Product: '.$product->name, $quantity, $product->wm_price);

        } else {
            $package = Package::find($request->id);
            $addtocart = Cart::add($package->id, 'Package: '.$package->name, $quantity, $package->wm_price);
        }

        return redirect()->back();
        //return response()->json($addtocart);

    }

    public function updateCart(Request $request, $id)
    {
        $rowId = $id;
        Cart::update($rowId, $request->qty);

        return back();
    }

    public function checkout()
    {   
        //$cust_address = 
        return view('shops.checkout');
    }

    public function cart()
    {
        return view('shops.cart');
    }

    public function agentStoreCart($id)
    {
        return view('shops.cart', compact('id'));
    }

    public function emptyCart()
    {
        Cart::destroy();

        return redirect()->back();
    }

    //End Cart
}
