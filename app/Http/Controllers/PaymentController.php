<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Payment;
use App\AgentPayment;
use App\Product;
use App\ProductSale;
// use App\Package;
use App\User;
use App\Profile;
// use App\Voucher;
use App\Invoice;
use App\AgentInvoice;
use App\Order;
use App\AgentOrder;
use App\OrderItem;
use App\AgentOrderItem;
use App\Bonus;
use App\BonusType;
use App\Rank;
use App\Wallet;
use App\Referral;
use App\Store;
use App\Sale;
use App\UserPurchase;
use App\ActiveDo;
use App\ActiveSdo;

use Carbon\Carbon;

use Validator;
use Session;
use Cart;
use DateTime;

class PaymentController extends Controller
{
    public function options(Request $request)
	{
		$payment_method = $request->payment_method;
        // $last_invoice_no    = Invoice::latest()->value('invoice_no');
        // $new_invoice_no     = isset($last_invoice_no) ? $last_invoice_no + 1: 10000;
        $customer           = Auth::guard('web')->user();

        $id = isset($request->agent_user_id) ? $request->agent_user_id:0;//agent_id
        $user = User::find($id);//agent info

        if(isset($id) && $id >0 ){
            $last_invoice_no    = AgentInvoice::latest()->value('invoice_no');
            $new_invoice_no     = (!is_null($last_invoice_no)) ? $last_invoice_no + 1: 10000;
        } else {
            $last_invoice_no    = Invoice::latest()->value('invoice_no');
            $new_invoice_no     = (!is_null($last_invoice_no)) ? $last_invoice_no + 1: 10000;
        }

        // echo '<pre>';
        // echo $last_invoice_no;
        // echo '<pre>';

        switch ($payment_method) {
            case 'Cash':
                $url = 'payments.cash';
                break;

            case 'Credit/Debit_Card':
                $url = 'payments.credit_debit_card';
                break;

            case 'FPX':
                $url = 'payments.fpx';
                break;

            case 'Ewallet':
                $url ='payments.ewallet';
                break;
        }

        return view($url, compact('customer','new_invoice_no', 'id', 'user'));
	}

	public function cash()
    {
        $last_invoice_no    = Invoice::latest()->value('invoice_no');
        $new_invoice_no     = isset($last_invoice_no) ? $last_invoice_no + 1: 10000;
        $customer           = Auth::guard('user')->user();
        //$rebate             = $this->getPersonalRebate($customer->id);

    	return view('payments.cash', compact(['customer','new_invoice_no', 'rebate']));
    }

    public function postPayCash(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'cash'          => 'required|numeric',
            ]);

         if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        } else {
            $balance = $this->checkBalance($request->all());

            $user_id        = $request->user_id;
            $voucher_value  = $request->has('voucher_code') ? $request->voucher_value : 0;
            $payment_status = $balance == 0 ? 'Fully Paid' : 'Partially Paid';

            if($request->has('voucher_code'))
            {
                $data = [
                    'voucher_value'     => $voucher_value,
                    'payment_type'      => 'Cash + Voucher',
                    'payment_status'    => $payment_status,
                ];

                $payment = $this->processPayment($request->all(), $data);

            }else {
                $data = [
                    'voucher_value'     => 0,
                    'payment_type'      => 'Cash',
                    'payment_status'    => $payment_status,
                ];

                $payment = $this->processPayment($request->all(), $data);
            }
        }

        return redirect('invoices');
    }

    public function processPayment($input, $data)
    {
        $total_pv         = $this->getTotalPv();
        $total_rmvp       = $this->getTotalRmvp(); 

        if(isset($input['agent_user_id']) && $input['agent_user_id'] != 0)
        {
            $invoice = new AgentInvoice;
            $invoice->agent_id      = $input['agent_user_id'];
            $invoice->invoice_no    = $this->getLastAgentInvoiceNo();//$input['invoice_no'];
            $invoice->user_id       = $input['user_id'];//customer id
            $invoice->total         = Cart::total();
            $invoice->delivery_cost = 10;
            $invoice->status        = $data['payment_status'];
            $invoice->balance       = 0;
            $invoice->save();

            $payment = new AgentPayment;
            $payment->agent_id      = $input['agent_user_id'];
            $payment->invoice_id    = $invoice->id;
            $payment->cash          = $input['cash'];
            $payment->voucher       = $data['voucher_value'];
            $payment->status        = $data['payment_status'];
            $payment->payment_type  = $data['payment_type'];
            $payment->save();
        } 
        else
        {
            $invoice = new Invoice;
            $invoice->invoice_no    = $this->getLastInvoiceNo() + 1;
            $invoice->user_id       = $input['user_id'];
            $invoice->total         = Cart::total();
            $invoice->delivery_cost = 10;
            $invoice->status        = $data['payment_status'];
            $invoice->balance       = 0;
            $invoice->save();

            $payment = new Payment;
            $payment->invoice_id    = $invoice->id;
            $payment->cash          = $input['cash'];
            $payment->voucher       = $data['voucher_value'];
            $payment->status        = $data['payment_status'];
            $payment->payment_type  = $data['payment_type'];
            $payment->save();
        }

        if($data['payment_status'] == 'Fully Paid')
        {
            $order_status = 'New Order';
        }
        elseif($data['payment_status'] == 'Partially Paid')
        {
            $order_status = 'Pending';
        }

        if(isset($input['agent_user_id']) && $input['agent_user_id'] != 0)
        {
            $order_no = AgentOrder::latest()->value('do_no');

            if (isset($order_no)){
                $new_order_no = $order_no + 1;
            } else {
                $new_order_no = 100000000;
            }

            $order = new AgentOrder;
            $order->user_id     = $input['user_id'];
            $order->invoice_id  = $invoice->id;
            $order->do_no       = $new_order_no;
            $order->total_items = Cart::count();
            $order->status      = $order_status;
            $order->save();

            foreach (Cart::content() as $item) {
                $order_item = new AgentOrderItem;
                $order_item->order_id   = $order->id;
                $order_item->product_id = $item->id;
                $order_item->qty        = $item->qty;
                $order_item->save();   
            }
        } 
        else
        {
            $order_no = Order::latest()->value('do_no');

            if (isset($order_no)){
                $new_order_no = $order_no + 1;
            } else {
                $new_order_no = 100000000;
            }

            $order = new Order;
            $order->user_id     = $input['user_id'];
            $order->invoice_id  = $invoice->id;
            $order->do_no       = $new_order_no;
            $order->total_items = Cart::count();
            $order->status      = $order_status;
            $order->save();

            
            $user_rank_id = User::find($input['user_id'])->rank_id;

            if($data['payment_status'] == 'Fully Paid' && $user_rank_id > 2)
            {
                foreach (Cart::content() as $item) 
                {
                    $order_item = new OrderItem;
                    $order_item->order_id   = $order->id;
                    $order_item->product_id = $item->id;
                    $order_item->qty        = $item->qty;
                    $order_item->save();

                    // $product_sales = ProductSale::where('product_id', $item->id)
                    //                               ->where('month', Carbon::today()->month)
                    //                               ->where('year', Carbon::today()->year)
                    //                               ->first();
                    $product_sales = ProductSale::firstOrNew(['product_id' => $item->id, 'month' => Carbon::today()->month, 'year' => Carbon::today()->year]);
                    $product_sales->quantity = $product_sales->quantity + $item->qty;
                    $product_sales->amount   =  $product_sales->amount + ($item->qty * $item->price);
                    $product_sales->month = Carbon::today()->month;
                    $product_sales->year  = Carbon::today()->year;
                    $product_sales->save();

                    $pv = Product::find($item->id)->pv;

                    for($qty = 0; $qty < $item->qty; $qty++)
                    {
                        $store = new Store;
                        $store->user_id     = $input['user_id'];
                        $store->product_id  = $item->id;
                        $store->product_name= $item->name;
                        $store->price       = $item->price;
                        $store->pv          = $pv;
                        $store->status      = 'Stocking';
                        $store->save();
                    } 
                }

                $wallet = Wallet::firstOrNew(['user_id'  => $input['user_id']] );
                //$wallet->current_pv   = $wallet->current_pv + $total_pv;
                //$wallet->available_pv   = $wallet->available_pv + $pv;
                if(!$wallet->exists || $wallet->purchased == 0)
                {
                    $wallet->rmvp            = $wallet->rmvp + $total_rmvp;
                    $wallet->pv              = $wallet->pv + $total_pv;
                    $wallet->first_purchased = $total_pv; 
                    $wallet->purchased       = 1;
                }
                else
                {
                    $wallet->rmvp            = $wallet->rmvp + $total_rmvp;
                    $wallet->pv              = $wallet->pv + $total_pv;
                    $wallet->purchased       = $wallet->purchased + 1;
                }
                
                $wallet->save();

                $year = (new DateTime)->format("Y");
                $month = (new DateTime)->format("n");

                $sale = Sale::firstOrNew(['year' => $year , 'month' => $month]);
                $sale->total_pv     = $sale->total_pv + $total_pv;
                $sale->total_sale   = $sale->total_sale + Cart::total();
                $sale->save();
            } 
            elseif ($data['payment_status'] == 'Fully Paid' && $user_rank_id <= 2)
            {
                foreach (Cart::content() as $item) 
                {
                    $order_item = new OrderItem;
                    $order_item->order_id   = $order->id;
                    $order_item->product_id = $item->id;
                    $order_item->qty        = $item->qty;
                    $order_item->save();

                    $product_sales = ProductSale::where('product_id', $item->id)
                                                  ->where('month', Carbon::today()->month)
                                                  ->where('year', Carbon::today()->year)
                                                  ->first();
                    // $product_sales = ProductSale::firstOrNew(['product_id' => $item->id, 'month' => Carbon::today()->month, 'year' => Carbon::today()->year]);
                    if($product_sales)
                    {
                        $product_sales->quantity    = $product_sales->quantity + $item->qty;
                        $product_sales->amount      = $product_sales->amount + ($item->qty * $item->price);
                        $product_sales->month       = Carbon::today()->month;
                        $product_sales->year        = Carbon::today()->year;
                        $product_sales->save();
                    } else

                    {
                        $product_sales = new ProductSale;
                        $product_sales->quantity    = $product_sales->quantity + $item->qty;
                        $product_sales->amount      = $product_sales->amount + ($item->qty * $item->price);
                        $product_sales->month       = Carbon::today()->month;
                        $product_sales->year        = Carbon::today()->year;
                        $product_sales->save();
                    }
                   

                    $pv = Product::find($item->id)->pv;

                    for($qty = 0; $qty < $item->qty; $qty++)
                    {
                        $userPurchase = new UserPurchase;
                        $userPurchase->user_id     = $input['user_id'];
                        $userPurchase->product_id  = $item->id;
                        $userPurchase->product_name= $item->name;
                        $userPurchase->price       = $item->price;
                        $userPurchase->pv          = $pv;
                        $userPurchase->status      = 'Shipping';
                        $userPurchase->save();
                    }
                }

                $wallet = Wallet::firstOrNew(['user_id'  => $input['user_id']] );
                //$wallet->available_pv   = $wallet->available_pv + $pv;
                if(!$wallet->exists || $wallet->purchased == 0)
                {
                    $wallet->rmvp            = $wallet->rmvp + $total_rmvp;
                    $wallet->pv              = $wallet->pv + $total_pv;
                    $wallet->first_purchased = $total_pv; 
                    $wallet->purchased       = 1;
                }
                else
                {
                    $wallet->rmvp            = $wallet->rmvp + $total_rmvp;
                    $wallet->pv              = $wallet->pv + $total_pv;
                    $wallet->purchased       = $wallet->purchased + 1;
                }

                $wallet->save();

                $user = User::find($wallet->user_id);

                if($user->rank_id == 1)
                {
                    if($total_pv >= 200 && $total_pv < 1000)
                    {
                        $user->rank()->associate(2);
                        $user->save();
                    }
                    elseif($total_pv >= 1000 && $total_pv < 5000)
                    {
                        $user->rank()->associate(3);
                        $user->save();
                    }
                    elseif($total_pv >= 5000)
                    {
                        $user->rank()->associate(3);
                        $user->save();
                    }
                }
                elseif($user->rank_id == 2)
                {
                    if($total_pv >= 1000 && $total_pv < 5000)
                    {
                        $user->rank()->associate(3);
                        $user->save();
                    }
                    elseif($total_pv >= 5000)
                    {
                        $user->rank()->associate(3);
                        $user->save();
                    }
                }
                elseif($user->rank_id == 3)
                {
                    if($total_pv >= 5000)
                    {
                        $user->rank()->associate(3);
                        $user->save();
                    }
                }

                //if user rank upgrade to do or sdo
                if($user->rank_id == 4)
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
                elseif($user->rank_id < 4 )
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
                
                elseif($user->rank_id == 5) 
                {
                    $active_do = new ActiveDo;
                    $active_do->user_id = $user->id;
                    $active_do->rank    = $request->rank;
                    $active_do->save();

                    $active_sdo = new ActiveSdo;
                    $active_sdo->user_id = $user->id;
                    $active_sdo->rank    = $request->rank;
                    $active_sdo->save();
                }
                // END - if user rank upgrade to 'do' or 'sdo'

                $referral = Referral::where('user_id', $user->id)->first();

                if($user->rank->code_name !== $referral->rank)
                {
                    $referral->rank = $user->rank->code_name;
                    $referral->save();
                }

                $year = (new DateTime)->format("Y");
                $month = (new DateTime)->format("n");

                $sale = Sale::firstOrNew(['year' => $year , 'month' => $month]);
                $sale->total_pv     = $sale->total_pv + $total_pv;
                $sale->total_sale   = $sale->total_sale + Cart::total();
                $sale->save();
            }
            
        }

        Cart::destroy();

        return $payment;
    }

    public function checkBalance($data)
    {
        $cash           = $data['cash'];
        $voucher_value  = isset($data['voucher_code']) ? $data['voucher_value'] : 0;

        if($voucher_value != 0 ){
            $balance    = Cart::total() - $cash - $voucher_value;
        } else {
            $balance    = Cart::total() - $cash;
        }

        return $balance;
    }

    public function getTotalPv()
    {
        $pv = 0;

        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);
            $pv      = $pv + ($item->qty * $product->pv);
        }

        return $pv;
    }

    public function getTotalRmvp()
    {
        $rmvp = 0;

        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);
            $rmvp     = $rmvp + ($item->qty * $product->wm_price);
        }

        return $rmvp;
    }

    public function getLastInvoiceNo()
    {
        $invoice_no = Invoice::latest()->value('invoice_no');

        if(!$invoice_no)
        {
            $invoice_no = 1000000;
        }

        return $invoice_no;
    }

    public function getLastAgentInvoiceNo()
    {
        return $agent_invoice_no = AgentInvoice::max('invoice_no');
    }
}
