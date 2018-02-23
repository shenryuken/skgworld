<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Order;
use App\OrderItem;
use App\Courier;
use App\Shipment;
use App\ShippedItem;
use App\Store;
use App\UserPurchase;

use Validator;
use Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        
    	return view('orders.index', compact('orders'));
    }

    public function myOrders()
    {
        $id  = Auth::guard('web')->user()->id;  
        $orders = Order::where('user_id', $id)->get();

        return view('orders.my-orders', compact('orders'));
    }

    public function show($id)
    {
    	$order = Order::find($id);
        $items = $order->orderItems;

    	return view('orders.show', compact('order', 'items'));
    }

    public function processOrder($id)
    {   
        $order = Order::find($id);
        $items = $order->orderItems;
        $couriers = Courier::all();
        
        return view('orders.process', compact(['order', 'items', 'couriers']));
    }

    public function postProcessOrder(Request $request)
    {
        $request->validate([
                //'order_id'          => 'required|unique:shipments,order_id',
                'item_id.*'         => 'required',
                'serial_no.*'       => 'required|distinct|unique:shipped_items,serial_no',
                'courier_id'        => 'required',
                'consignment_note'  => 'required|unique:shipments,consignment_note',
                'security_code'     => 'required'
            ]);

        $hashedCode = Auth::guard('admin')->user()->security_code;

        if(Auth::guard('admin')->check() && Hash::check($request->security_code, $hashedCode)){

            $order = Order::find($request->order_id);
            $order->status = 'Shipping';
            $order->save();

            $shipment = new Shipment();
            $shipment->user_id              = $order->user_id;
            $shipment->order_id             = $order->id;
            $shipment->courier_id           = $request->courier_id;
            $shipment->consignment_note     = $request->consignment_note;
            $shipment->status               = 'Shipping';
            $shipment->save(); 

            $item_ids = $request->item_id;
            $i = 0;
            $sno = array();

            foreach($item_ids as $item_id)
            {
                $shippedItem = new ShippedItem;
                $shippedItem->shipment_id = $shipment->id;
                $shippedItem->product_id  = $item_id;
                $shippedItem->serial_no   = $request->serial_no[$i];
                $shippedItem->save();

                $store = Store::where('user_id',$order->user_id)
                                ->where('product_id', $item_id)
                                ->whereIn('serial_no', [NULL, ''])->first();

                if( !is_null($store))
                {
                    $store->serial_no = $request->serial_no[$i];
                    $store->save();
                } 
                else 
                {
                    $userPurchase = UserPurchase::where('user_id',$order->user_id)
                                                    ->where('product_id', $item_id)
                                                    ->whereIn('serial_no', [NULL, ''])->first(); 
                    $userPurchase->serial_no = $request->serial_no[$i];
                    $userPurchase->save();
                }   
                    
                $sno[] = $shippedItem->serial_no;

                $i++;
            }

            $orderItem = OrderItem::find($order->id);
            $orderItem->serial_no = json_encode($sno);
            $orderItem->save();
        

            // Session::flash('success', 'Successfully Process The Order: #'.$order->do_no);
            return back()->with('success', 'Successfully Process The Order: #'.$order->do_no)
                        ->withInput();
        }

        return back()->with('fail', 'Action Failed! Please make sure your security code is correct.');
    }
}
