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
use App\NewUser;
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
        $prev_url = $request->previous_path;

        if($prev_url == 'shop/first-cart')
        {
            $customer = NewUser::find($request->uid);
        }
        else
        {
            $customer = Auth::guard('web')->user();
        }

        //echo $prev_url;
        //var_dump($customer);

		$payment_method     = $request->payment_method;
        $last_invoice_no    = Invoice::latest()->value('invoice_no');
        $new_invoice_no     = isset($last_invoice_no) ? $last_invoice_no + 1: 10000;

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

        return view($url, compact('customer','new_invoice_no', 'id', 'user', 'prev_url'));
	}

	public function cash()
    {
        if($request->prev_url == 'shop/first-cart')
        {
            $last_invoice_no    = Invoice::latest()->value('invoice_no');
            $new_invoice_no     = isset($last_invoice_no) ? $last_invoice_no + 1: 10000;
            $customer           = NewUser::find('user_id');
        }
        else
        {
            $last_invoice_no    = Invoice::latest()->value('invoice_no');
            $new_invoice_no     = isset($last_invoice_no) ? $last_invoice_no + 1: 10000;
            $customer           = Auth::guard('user')->user();
        }
        
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
                    'prev_url'          => $request->prev_url,
                ];

                $payment = $this->processPayment($request->all(), $data);

            }else {
                $data = [
                    'voucher_value'     => 0,
                    'payment_type'      => 'Cash',
                    'payment_status'    => $payment_status,
                    'prev_url'          => $request->prev_url,
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

        if($data['payment_status'] == 'Fully Paid')
        {
            $order_status = 'New Order';
        }
        elseif($data['payment_status'] == 'Partially Paid')
        {
            $order_status = 'Pending';
        }

        $invoice    = $this->createInvoice($input['user_id'], $input['agent_user_id'], $data);
        $order      = $this->addNewOrder($input['user_id'], $input['agent_user_id'], $data['prev_url'], $invoice, $order_status);
        $orderItem  = $this->addOrderItem($order, $input['agent_user_id']);
        $updateStore= $this->addTostore($input['user_id']);
          
        $year = (new DateTime)->format("Y");
        $month = (new DateTime)->format("n");

        $sale = Sale::firstOrNew(['year' => $year , 'month' => $month]);
        $sale->total_pv     = $sale->total_pv + $total_pv;
        $sale->total_sale   = $sale->total_sale + Cart::total();
        $sale->save();
            
            
        }

        Cart::destroy();

        // return $payment;
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

    public function createInvoice($user_id, $agent_id = null, $data)
    {
        if($agent_id != NULL || $agent_id != '')
        {
            $invoice = new AgentInvoice;
            $invoice->agent_id      = $agent_id;
            $invoice->invoice_no    = uniqid();//$this->getLastAgentInvoiceNo();//$input['invoice_no'];
            $invoice->user_id       = $user_id;//customer id
            $invoice->total         = Cart::total();
            $invoice->delivery_cost = 10;
            $invoice->status        = $data['payment_status'];
            $invoice->balance       = 0;
            $invoice->save();

            $payment = new AgentPayment;
            $payment->agent_id      = $agent_id;
            $payment->invoice_id    = $invoice->id;
            $payment->cash          = 'cash';
            $payment->voucher       = $data['voucher_value'];
            $payment->status        = $data['payment_status'];
            $payment->payment_type  = $data['payment_type'];
            $payment->save();
        }
        else
        {
            $invoice = new Invoice;
            $invoice->invoice_no    = $this->getLastInvoiceNo() + 1;
            $invoice->user_id       = $user_id;
            $invoice->total         = Cart::total();
            $invoice->delivery_cost = 10;
            $invoice->status        = $data['payment_status'];
            $invoice->balance       = 0;
            $invoice->save();

            $payment = new Payment;
            $payment->invoice_id    = $invoice->id;
            $payment->cash          = 'cash';
            $payment->voucher       = $data['voucher_value'];
            $payment->status        = $data['payment_status'];
            $payment->payment_type  = $data['payment_type'];
            $payment->save();
        }

        return $invoice;
    }

    public function addNewOrder($user_id, $agent_id = null, $prev_url, $invoice, $order_status)
    {
        $new_order_no = $this->getNewOrderNo($user_id, $agent_id);
        $model = ($agent_id != NULL || $agent_id != '') ? 'AgentOrder':'Order';

        $order = new $model;
        $order->user_id     = $user_id;
        $order->invoice_id  = $invoice->id;
        $order->do_no       = $new_order_no;
        $order->total_items = Cart::count();
        $order->status      = $order_status;
        $order->save();
    
        $product_sale = $this->productSale($agent_id);
        
        return $order;
    }

    public function getNewOrderNo($user_id, $agent_id = null)
    {
        $model = ($agent_id != NULL || $agent_id != '') ? 'AgentOrder':'Order';

        $order_no = $model::latest()->value('do_no');

        $new_order_no = isset($order_no) ? ($order_no + 1) : 100000000;

        return $new_order_no;
    }

    public function productSale($agent_id = null)
    {
        if($agent_id == NULL || $agent_id == '')
        {
            foreach (Cart::content() as $item) 
            {
                $product_sales = ProductSale::firstOrNew(['product_id' => $item->id, 'month' => Carbon::today()->month, 'year' => Carbon::today()->year]);
                $product_sales->quantity = $product_sales->quantity + $item->qty;
                $product_sales->amount   = $product_sales->amount + ($item->qty * $item->price);
                $product_sales->month    = Carbon::today()->month;
                $product_sales->year     = Carbon::today()->year;
                $product_sales->save();
            }
        }
    }

    public function addOrderItem($order,  $agent_id = null)
    {
        $model = ($agent_id != NULL || $agent_id != '') ? 'AgentOrderItem':'OrderItem';

        foreach (Cart::content() as $item) {
                $order_item = new $model;
                $order_item->order_id   = $order->id;
                $order_item->product_id = $item->id;
                $order_item->qty        = $item->qty;
                $order_item->save();   
            }
    }

    public function generateInvoiceNo()
    {
        //
    }

    public function addToStore($user_id)
    {
        $rank_id = User::find($user_id)->rank_id;

        $model = $rank_id > 2 ? 'Store' : 'UserPurchase';

        foreach( Cart::content() as $item )
        {
            $pv = Product::find($item->id)->pv;

            for($qty = 0; $qty < $item->qty; $qty++)
            {
                $store = new $model;
                $store->user_id     = $user_id;
                $store->product_id  = $item->id;
                $store->product_name= $item->name;
                $store->price       = $item->price;
                $store->pv          = $pv;
                $store->status      = 'Stocking';
                $store->save();
            } 
        }
        
    }

    public function updateOrCreateWallet($user_id)
    {
        $total_pv         = $this->getTotalPv();
        $total_rmvp       = $this->getTotalRmvp();

        $wallet = Wallet::firstOrNew(['user_id'  => $user_id]);
       
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

        $updateUserRank = $this->updateUserRank($user_id);
    }

    public function updateUserRank($user_id)
    {
        $total_pv      = $this->getTotalPv();
        $qualifiedRank = $this->getQualifiedRank($user_id);
        
        $user = User::find($user_id);

        if($qualifiedRank > $user->rank_id)
        {
            $user->rank()->associate($qualifiedRank);
            $user->save(); 

            $referral = Referral::where('user_id', $user->id)->first();
            $referral->rank = $user->rank->code_name;
            $referral->save();
            
            if($qualifiedRank == 4)
            {
                $active_do = new ActiveDo;
                $active_do->user_id = $user->id;
                $active_do->rank    = $request->rank;
                $active_do->save();
            }
        }
    }

    public function getQualifiedRank($user_id)
    {
        $total_pv = $this->getTotalPv();

        switch ($total_pv) {
            case ($total_pv >= 200 && $total_pv < 1000):
                $rank_id = 2;
                break;
            case ($total_pv >= 1000 && $total_pv < 5000):
                $rank_id = 3;
                break;
            case ($total_pv >= 5000):
                $rank_id = 4;
                break;
            default:
                $rank_id = 1;
                break;
        }

        return $rank_id;
    }

}
