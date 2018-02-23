<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Admin;
use App\User;
use App\Shipment;
use App\ShippedItem;
use App\Order;
use App\OrderItem;

use Validator;
use Session;

class ShipmentController extends Controller
{
    public function index()
    {
    	if(Auth::guard('admin')->check())
    	{
    		$shipments = Shipment::all();
    	}
    	else
    	{
    		$shipments = Shipment::where('user_id', Auth::user()->id)->get();
    	}

    	return view('shipments.index', compact('shipments'));
    }
}
