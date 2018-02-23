<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;
use App\AgentInvoice;
use App\Order;
use App\AgentOrder;
use App\Payment;
use App\Shipment;

use Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        // if(Auth::guard('admin')->check())
        // {
            $invoices  = Invoice::all();
            // $invoices2 = null, 
        // }
        // else 
        // {
        //     // $id  = Auth::user()->id;  
        //     // $invoices  = AgentInvoice::where('agent_id', $id)->get();   
        //     $this->myInvoice; 
        // }

    	return view('invoices.index', compact('invoices'));
    }

    public function show($id)
    {
		$invoice     = Invoice::find($id);
    	$order 	     = Order::where('invoice_id', $id)->first();
        $order_items = $order->orderItems;
    	$payments    = Payment::where('invoice_id', $invoice->id)->get();
        $shipment    = $order->shipment;
    	
    	return view('invoices.show', compact('invoice', 'order', 'payments', 'order_items', 'shipment'));
    }

    public function myInvoices()
    {
        $id = Auth::user()->id;

        $invoices   = Invoice::where('user_id', $id)->get();
        $invoices2  = AgentInvoice::where('user_id', $id)->get();

        // $invoice    = Invoice::where('user_id',$id)->get();
        // $order      = Order::where('invoice_id', $id)->first();
        // $order_items= $order->orderItems;
        // $payments   = Payment::where('invoice_id', $id)->get();
        // $shipment   = $order->shipment;

        // $invoices2  = AgentInvoice::where()
        // $order2     = AgentOrder::where('user_id', $id)->

        //return view('invoices.my-invoice', compact('invoice', 'order', 'payments', 'order_items', 'shipment'));
        return view('invoices.my-invoices', compact('invoices', 'invoices2'));
    }

    public function getAllCustomerInvoices($id)
    {
        //$id is user_id for the Agent
        $invoices = AgentInvoice::where('agent_id', $id)->get();

        return view('invoices.my-customer-invoices', compact('invoices'));
    }

    public function showCustomerInvoice($id)
    {
        //$id is invoice_id
        $invoice     = AgentInvoice::find($id);
        $agentOrder  = AgentOrder::where('invoice_id', $id)->first();
        $order_items = $agentOrder->agentOrderItems;
        $payments    = AgentPayment::where('invoice_id', $invoice->id)->get();
        $shipment    = $agentOrder->agentShipment;

        return view('invoices.show-customer-invoice', compact('invoice'));
    }


}
