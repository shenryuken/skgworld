@extends('layouts.joli.app')
{{-- Page title --}}
@section('title')
Store
@parent
@stop

<?php $page_title = $user->username."'s Store"; ?>
@section('content')

<div class='row'>
	@foreach($products as $product)
	<div class="col-md-3">
		<div class="panel panel-default">
	        <div class="panel-heading">
	            <div class="media clearfix">
	                <h3 class="font-bold">{{ $product->product_name }}</h3>
	            </div>
	        </div>
	        <div class="panel-image">
	            <img class="img-responsive" src="{{asset('product/femlove.jpg')}}" alt="">
	        </div>
	        <div class="panel-body">
	            {{-- <p>
	                Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
	            </p> --}}
	            
	            <h4 class="font-bold">
                    WM : MYR {{ $product->wm_price }}  
                </h4>
                <h4 class="font-bold">
                    EM : MYR {{ $product->em_price }}  
                </h4>
	            <p>
	                ({{ $product->pv}} PV)
	            </p>

			</div>			
	        <div class="panel-footer">
                <form action="{{url('shop/addToCart')}}" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="itemType" value="product">
					<input type="hidden" name="id" value="{{ $product->id }}">
					<div class="col-md-3">
						<div class="form-group">
			                <label>Quantity</label>
			                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="quantity">
			                @for($i = 1; $i <= 10; $i++)
		                  		<option value="{{ $i }}"> {{$i}} </option>
		                  	@endfor
			                </select>
		                </div>
					</div>
					<button type="submit" class="btn btn-block btn-danger">Add to cart</button>
				</form>
	        </div>
	    </div>
    </div>
    @endforeach
</div>
@stop
{{-- page level scripts --}}
@section('footer_scripts')
@stop