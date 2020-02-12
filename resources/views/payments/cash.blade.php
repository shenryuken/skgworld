@extends('layouts.joli.app')
  {{-- Page title --}}
@section('title')
  Cash
@parent
@stop
@section('header_styles')
<link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}" type="text/css" />
@stop
<?php $page_title = 'Invoice '; ?>
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
@if (count($errors) > 0)
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

  <h1>
  <small>#007612</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li>
    <li class="active">Invoice</li>
  </ol>
</section>
<div class="pad margin no-print">
  <div class="callout callout-info" style="margin-bottom: 0!important;">
    <h4><i class="fa fa-info"></i> Note:</h4>
    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
      This Is Note
    </p>
  </div>
</div>
<!-- Main content -->
<form method="post" action="{{ url('payments/postPayCash')}}">
{{ csrf_field() }}
@if(isset($id))
<input type="hidden" name="agent_user_id" value="{{ $id }}">
@endif
<input type="hidden" name="prev_url" value="{{ $prev_url}}">
<input type="hidden" name="user_id" value="{{ $customer->id }}">
{{-- <input type="hidden" name="invoice_no" value="{{ $new_invoice_no}}"> --}}
<section class="invoice">
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
      <i class="fa fa-globe"></i> AdminLTE, Inc.
      <small class="pull-right">Date: {{ \Carbon\Carbon::now()->format('d-M-Y')}} </small>
      </h2>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      From
      @if(isset($user))
      <address>
        <strong>{{$user->username}}</strong><br>
        @if($user->profile !== null)
        {{ $user->profile->street }},<br>
        {{ $user->profile->postcode }}, {{ $user->profile->city }}, <br>
        {{ $user->profile->state }}<br>
        @else
        Profile Not Complete!!
        @endif
        Phone: {{ $user->mobile_no }}<br>
        Email: {{ $user->email }}
      </address>
      @else
      <address>
        <strong>Admin, SKG WORLD SDN BHD,</strong><br>
        Block G-3-2,Encorp Strand Garden Office,<br>
        47810 Kota Damansara,<br>
        Petaling Jaya, Selangor,<br>
        Phone: (+6) 03-6144 6399 <br>
        Email: admin@skgworld.com
      </address>
      @endif
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      To
      <address>
        @if($customer->profile !== null)
        <strong>{{ $customer->profile->full_name }} </strong><br>
        {{ $customer->profile->street }},<br>
        {{ $customer->profile->postode }}, {{ $customer->profile->city }}<br>
        {{$customer->profile->state }}, {{ $customer->profile->country }}<br>
        Phone: {{ $customer->profile->contact_no1 }} <br>
        Email: {{ $customer->email }}
        @else
        No Data Were Found!
        @endif
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Invoice #{{ $new_invoice_no}}</b><br>
      <br>
      <b>Order ID:</b> 4F3S8J<br>
      <b>Payment Due:</b> 2/22/2014<br>
      <b>Account:</b> 968-34567
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>
            <!--th>Serial #</th-->
            <th>Description</th>
            <th>Price/Unit</th>
            <th>Subtotal+GST(6%)</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach(Cart::content() as $item)
          <tr>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->name }}</td>
            <td>
              <?php
              $product_desc = App\Product::find($item->id)->description;
              ?>
              {{ $product_desc }}
            </td>
            <td>{{ $item->price }}</td>
            <td>{{ number_format($item->subtotal,2,'.',',') }} + {{ $item->tax()*$item->qty }}</td>
            <td>{{ number_format($item->total,2,'.',',') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row">
    
    <!-- /.col -->
    <div class="col-xs-6 pull-right">
      <p class="lead">Amount Due 2/22/2014</p>
      <div class="table-responsive">
        <table class="table">
          <tbody><tr>
            <th style="width:50%">Subtotal:</th>
            <td>MYR {{ Cart::subtotal() }}</td>
          </tr>
          <tr>
            <th>Total GST(6%)</th>
            <td>MYR {{ Cart::tax()}}</td>
          </tr>
          <tr>
            <th>Shipping:</th>
            <td>MYR 10.00</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td>MYR {{ Cart::total()}}</td>
          </tr>
        </tbody></table>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <hr>
  <div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6 form-horizontal payments pull-right">
      <div class="form-group ">
        <label class="col-xs-2 control-label">Cash</label>
        <div class="col-xs-4">
          <input type="text" name="cash" class="form-control" />
        </div>
      </div>
    </div>
  </div>
  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
      <button class="btn btn-default add_field_voucher">Add Voucher</button>
      <!--form method="post" -->
      <button type="Submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
      </button>
      <!--/form-->
      <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
      <i class="fa fa-download"></i> Generate PDF
      </button>
    </div>
  </div>
</form>
</section>
<!-- /.content -->
<div class="clearfix"></div>
@stop
{{-- page level scripts --}}
@section('footer_scripts')

<script type="text/javascript">
  $(document).ready(function() {
  var wrapper           = $(".payments"); //Fields wrapper
  var max_fields_voucher  = 10; //maximum input boxes allowed
  var add_button_voucher  = $(".add_field_voucher"); //Add button ID
  
  var y = 1; //initlal text box count
  
  
  $(add_button_voucher).click(function(e){ //on add input button click
    e.preventDefault();
    if(y < max_fields_voucher){ //max input box allowed
      y++; //text box increment
    
      $(wrapper).append('<div class="form-group">'
        + '<label class="col-xs-2 control-label">Voucher</label>'
        + '<div class="col-xs-4">'
        + '<input type="text" name="voucher_code" class="form-control" />'
        + '</div>'
        + '<label class="col-xs-2 control-label">Value</label>'
        + '<div class="col-xs-4">'
        +  '<input type="text" name="voucher_value" class="form-control" placeholder="0" />'
        + '<a href="#" class="remove_field">Remove</a></div></div>'); //add input box
    }
  });
      
  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').parent('div').remove(); y--;
  });
  
  });

</script>
@stop