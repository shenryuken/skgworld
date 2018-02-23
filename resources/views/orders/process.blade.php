@extends('layouts.joli.app')
<?php $page_title = 'Process Order'; ?>
@section('content')

<!-- form start -->
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('fail'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div
@endif
<form class="form-horizontal" method="post" action="{{ url('orders/postProcessOrder')}}">
{{ csrf_field() }}
<input type="hidden" name="order_id" value="{{ $order->id }}">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		    <div class="panel-heading ui-draggable-handle">
		      <h3 class="panel-title"><strong>Items</strong></h3>
		      <ul class="panel-controls">
		        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
		      </ul>
		    </div>
		    <div class="panel-body">
	        
	          <div class="row">
	          	<div class="box-body">
			    @foreach($items as $item)    
	            <div class="col-xs-6">
	              <label class="control-label">Item Name</label>
	              <input class="form-control" name="item_name[]" value="{{ $item->product->name }}" type="text">
	              {{-- <input type="hidden" name="item_id[]" value="{{ $item->product->id }}"> --}}
	            </div>
	            @for($i=0; $i<$item->qty; $i++)
	            <div class="pull-right col-xs-6">
	              <input type="hidden" name="item_id[]" value="{{ $item->product->id }}">
	              <label class="control-label">Serial No.</label>
	              <input class="form-control" name="serial_no[]" type="text">
	            </div>
	            @endfor
	            @endforeach
	          </div>
	        </div>
	        <!-- /.box-body -->
	    	</div>
   		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		    <div class="panel-heading ui-draggable-handle">
		      <h3 class="panel-title"><strong>Courier</strong></h3>
		      <ul class="panel-controls">
		        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
		      </ul>
		    </div>
		    <div class="panel-body">
		    	
                <div class="form-group">
                  <label class="col-xs-2 control-label">Courier Service</label>
                  <div class="col-xs-4">
	                  <select class="form-control" name="courier_id">
	                  @foreach($couriers as $courier)
	                    <option value="{{ $courier->id}}">{{ $courier->company_name }}</option>
	                  @endforeach
	                  </select>
	              </div>
                </div>

                <div class="form-group">
                  <label for="inputPassword3" class="col-xs-2 control-label">Consigment Note</label>

                  <div class="col-xs-4">
                    <input class="form-control" name="consignment_note" type="text">
                  </div>
                </div>

                <div class="form-group">
					<label class="col-sm-2 control-label">Security Code</label>
					<div class="col-md-6 col-xs-12">
						<div class="input-group">
							<span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
							<input class="form-control" type="password" name="security_code" placeholder="Security Code Here">
						</div>
						{{-- <span class="help-block">This is sample of text field</span> --}}
					</div>
				</div>

              </div>
              <div class="panel-footer">
	        {{-- <button class="btn btn-default">Clear Form</button> --}}
	       	<button type="submit" class="btn btn-default pull-right">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Save</button>
	      </div>
          </div>
          
	</div>
</div>
</form>
@endsection