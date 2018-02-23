@extends('layouts.joli.app')
<?php $page_title = 'Delivery Orders'; ?>
@section('content')

<div class="row">
	<div class="col-md-4">

        <div class="panel panel-success push-up-20">
            <div class="panel-body panel-body-pricing">
                <h2>Order From: <strong style="text-transform: uppercase;">{{ $order->user->username }}</strong>
                	<br>
                	<small><strong>MYR {{ $order->invoice->total }}</strong></small>
                </h2>                                
                <p><span class="fa fa-caret-right"></span> <strong>DO No: #{{ $order->do_no }}</strong></p>
                <p><span class="fa fa-caret-right"></span> <strong>Status: {{ $order->status }}</strong></p>
                <p><span class="fa fa-caret-right"></span> <strong>Total Items: {{ $order->total_items }}</strong></p>
                <p><span class="fa fa-caret-right"></span> <strong>Total Price: MYR {{ $order->invoice->total }}</strong></p>
                <p><span class="fa fa-caret-right"></span> <strong>Delivery Price: MYR {{ $order->invoice->delivery_cost }}</strong></p>
                <p class="text-muted">For individuals</p>
            </div>
        </div>

    </div>
</div>

@stop