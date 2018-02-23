@extends('layouts.joli.app')
{{-- Page title --}}
<?php $page_title = 'Edit Bank'; ?>
@section('content')
<div class="row">
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


  <div class="col-md-12">                      
    <form class="form-horizontal" method="post" action="{{ action('BankController@update', $bank->id) }}">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PATCH">
    @if(Auth::guard('admin')->check())
    <input type="hidden" name="user_id" value="{{ Auth::guard('admin')->user()->id }}">
    
    <div class="panel panel-default">
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Edit - {{ $bank->name }}</strong></h3>
        <ul class="panel-controls">
          <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
        </ul>
      </div>
      <div class="panel-body">
        
        <div class="form-group">
          <label class="col-md-3 col-xs-12 control-label">Name</label>
          <div class="col-md-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
              <input class="form-control" type="text" name="name" value="{{$bank->name}}">
            </div>
            {{-- <span class="help-block">This is sample of text field</span> --}}
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 col-xs-12 control-label">Code</label>
          <div class="col-md-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
              <input class="form-control" type="text" name="code" value="{{$bank->code}}">
            </div>
            {{-- <span class="help-block">This is sample of text field</span> --}}
          </div>
        </div>

        <!-- select -->
	        <div class="form-group">
	          <label class="col-md-3 col-xs-12 control-label">Status</label>
	          <div class="col-md-6 col-xs-12">
	            <select name="status" class="form-control" onchange="SelectCheck(this);">
	              <option value="Local" {{ $bank->status == 'Local' ? ' selected="selected"' : ''}} >Local</option>
	              <option id="Option" value="Foreign">Foreign</option>
	            </select>
	          </div>
	        </div>

	        <!-- select -->
	        <div class="form-group" id="origin-div" style="display:none;">
	          <label class="col-md-3 col-xs-12 control-label">Origin Country</label>
	          <div class="col-md-6 col-xs-12">
	            <select name="origin_country" class="form-control">
	              <option value="Malaysia">Thailand</option>
	              <option value="Singapore">Singapore</option>
	              <option value="Indonesia">Indonesia</option>
	              <option value="China">China</option>
	            </select>
	          </div>
	        </div>

			<div class="form-group">
				<label class="col-md-3 col-xs-12 control-label">Security Code</label>
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
    @else
    {{ "You Do Not Have Permission For This Page !!"}}
    @endif
    </form>
  </div>
</div>

@endsection
{{-- page level scripts --}}
@section('footer_scripts')
<!-- START SCRIPTS -->
   
    <!-- START THIS PAGE PLUGINS-->        
    <script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/tableExport.js') }}"></script>
  <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jquery.base64.js"') }}"></script>
  <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/html2canvas.js') }}"></script>
  <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/sprintf.js') }}"></script>
  <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/jspdf.js') }}"></script>
  <script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/tableexport/jspdf/libs/base64.js') }}"></script>        
    <!-- END THIS PAGE PLUGINS-->  

    <!-- END SCRIPTS -->  
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