@extends('layouts.joli.app')

{{-- Page title --}}
@section('title')
    Create Bank
    @parent
@stop
<?php $page_title = 'Bank'; ?>
@section('content')

<div class="row">
    <div class="col-md-12">
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
		    </div>
		@endif 
		
		@if(Auth::guard('admin')->check())
	    <form class="form-horizontal" method="post" action="{{ url('/bank') }}">
		    <div class="panel panel-default">
		      {{ csrf_field() }}
		  
	            <div class="panel-heading">
	                <h3 class="panel-title"><strong>Bank</strong></h3>
	                <ul class="panel-controls">
	                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
	                </ul>
	            </div>
	      
	            <div class="panel-body">   
			        <div class="form-group">
			          <label for="bank_name" class="col-sm-2 control-label" >Bank Name</label>

			          <div class="col-sm-10">
			            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" style="text-transform: capitalize">
			          </div>
			        </div>

			        <div class="form-group">
			          <label for="code" class="col-sm-2 control-label">Code</label>

			          <div class="col-sm-10">
			            <input type="text" class="form-control" name="code" id="code" placeholder="Code">
			          </div>
			        </div>

			        <!-- select -->
			        <div class="form-group">
			          <label class="col-sm-2 control-label">Status</label>
			          <div class="col-sm-10">
			            <select name="status" class="form-control" onchange="SelectCheck(this);">
			              <option value="Local" selected="selected">Local</option>
			              <option id="Option" value="Foreign">Foreign</option>
			            </select>
			          </div>
			        </div>

			        <!-- select -->
			        <div class="form-group" id="origin-div" style="display:none;">
			          <label class="col-sm-2 control-label">Origin Country</label>
			          <div class="col-sm-10">
			            <select name="origin_country" class="form-control">
			              <option value="Malaysia">Thailand</option>
			              <option value="Singapore">Singapore</option>
			              <option value="Indonesia">Indonesia</option>
			              <option value="China">China</option>
			            </select>
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
		          <button class="btn btn-primary pull-right">Submit</button>
		        </div>
		    </div>
	    </form>
	    @else
			<h2>Yo dot not have permission for this action</h2>
	    @endif
	</div>
  <!-- /.box -->
</div>


@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<script>

function SelectCheck(nameSelect)
{
    if(nameSelect){
        OptionValue = document.getElementById("Option").value;
        if(OptionValue == nameSelect.value){
            document.getElementById("origin-div").style.display = "block";
        }
        else{
            document.getElementById("origin-div").style.display = "none";
        }
    }
    else{
        document.getElementById("origin-div").style.display = "none";
    }
}


</script>
@stop