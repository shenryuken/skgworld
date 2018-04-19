@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
Cart
@parent
@stop

<?php $page_title = 'Shopping Cart '; ?>
@section('content')
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading ui-draggable-handle">
      <h3 class="text-center">Your Cart</h3>

    </div>
    <div class="panel-body">
      <table class="table table-striped">
        <tbody><tr>
          <th style="width: 10px">#</th>
          <th>Item</th>
          <th>Quantity</th>
          <th>Price/Unit (Incl. 6% GST)</th>
          <th>Subtotal (Incl. 6% GST)</th>
          <th>GST (6%)</th>
          <th>Action</th>
        </tr>
        <?php $row = 1;?>
        @foreach(Cart::content() as $item)
        <tr>
          <td>{{ $row++}}</td>

          <td>{{ $item->name }}</td>
          {{-- <td>{{ $item->qty }}</td> --}}
          <td>
            <form method="post" action="{{action('ShopController@updateCart', $item->rowId)}}">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="PUT">
              <input type="text" name="qty" value="{{ $item->qty }}">
            </form> 
          </td>
          <td>{{ $item->price }}</td>
          <td>{{ $item->subtotal  }}</td>
          <td>{{ number_format($item->total - ($item->total * 100)/106, 2) }} </td>
          <td>
              <form action="{{ action('ShopController@removeFromCart', $item->rowId) }}" method="POST" class="use-ajax">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <button type='submit' class="{{ $class or 'btn btn-danger' }}" value="{{ $value or 'delete' }}">{!! $text or 'delete' !!}</button>
              </form>
          </td>
         {{--  <td>{{ $item->tax(6)*$item->qty }}</td> --}}
        </tr>
        @endforeach
        </tbody>
      </table>
      <a href="{{ URL::previous()  }}" class="btn btn-info "><b>Continue Shopping</b></a>
      <a href="{{ url('shop/emptyCart')}}" class="btn btn-primary "><b>Clear Cart</b></a>
      
    </div>
    <div class="panel-footer">
      <form action="{{ url('payments/options') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group col-md-10">
          @if(isset($id))
            <input type="hidden" name="agent_user_id" value="{{ $id }}">
          @else
            <input type="hidden" name="previous_path" value="shop/first-cart">
            <input type="hidden" name="uid" value="{{ Session::get('uid') }}">
          @endif
          <label class="col-md-2 control-label">Payment Method</label>
          <div class="col-md-8">
            <select class="form-control" aria-hidden="true" name="payment_method">
              <option value="Credit/Debit_Card"> Credit/Debit Card </option>
              <option value="Paypal"> Paypal </option>
              <option value="FPX"> FPX </option>
              <option value="Cash"> Cash </option>
              <option value="Mix_Payment">Mix Payment </option>
              <option value="Ewallet"> Ewallet </option>
          </select>
          </div>
          
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-warning pull-right">Check Out</button>
        </div>
        
      </form>
    </div>
  </div>
</div>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
@stop