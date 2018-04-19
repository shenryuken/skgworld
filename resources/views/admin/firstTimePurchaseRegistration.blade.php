@extends('layouts.joli.app')
<?php $page_title = 'Register New Member'; ?>
@section('content')
<div class="row">
    <div class="col-lg-12" style="">
        <div class="hpanel">
            <div class="panel-body">
                <h3>Products List</h3>
              <a href="{{ url('shop/first-cart')}}">
              <i class="fa fa-shopping-cart"></i>
              <span class="label label-success">{{ Cart::count()}}</span>
            </a>
            </div>
        </div>
    </div>
</div>
<div class='row'>
	@foreach($products as $product)
	<div class="col-md-3">
		<div class="panel panel-default">
	        <div class="panel-heading">
	            <div class="media clearfix">
	                <h3 class="font-bold">{{$product->name}}</h3>
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
                <form action="{{url('shop/addToCart')}}" method="post" class="use-ajax">
					{{ csrf_field() }}
					<input type="hidden" name="itemType" id="itemType" value="product">
					<input type="hidden" name="id" id="id" value="{{ $product->id }}">
					<div class="col-md-3">
						<div class="form-group">
			                <label>Quantity</label>
			                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="quantity" id="quantity">
			                @for($i = 1; $i <= 100; $i++)
		                  		<option value="{{ $i }}"> {{$i}} </option>
		                  	@endfor
			                </select>
		                </div>
					</div>
					<button type="submit" class="btn btn-block btn-danger btn-addtocart">Add to cart</button>
					
				</form>
				
	        </div>
	    </div>
    </div>

    @endforeach
</div>
<div class="row">
	<table cellpadding="10" cellspacing="1">
		<tbody>
		<tr>
			<th><strong>Name</strong></th>
			<th><strong>Code</strong></th>
			<th><strong>Quantity</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Action</strong></th>
		</tr>	
		@foreach(Cart::content() as $item)
		<tr>
			<td><strong>{{$item->name}}</strong></td>
			<td>{{$item->code}}</td>
			<td>{{$item->quantity}}</td>
			<td align=right>{{$item->price}}</td>
		</tr>
		@endforeach				

		<tr>
		<td colspan="5" align=right><strong>Total:</strong> {{Cart::total()}}</td>
		</tr>
		</tbody>
		</table>		
</div>

@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<!-- DataTables -->
<script src="{{ asset('themes/Homer/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('themes/Homer/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- THIS PAGE PLUGINS -->
    
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/dropzone/dropzone.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/fileinput/fileinput.min.js')}}"></script>  
<!-- END THIS PAGE PLUGINS -->  

<!-- END SCRIPTS -->     
@stop