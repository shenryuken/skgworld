@extends('layouts.joli.app')
{{-- Page title --}}

@section('header_styles')
<style type="text/css">
div.checkbox {padding-top:10px;}
input[type=checkbox] + div {display:inline; }

input[type=checkbox] + div[class*="pid-"]  input[target=hidden] { visibility:hidden;}

/* Toggled State */
input[type=checkbox]:checked + div[class*="pid-"]  input[target=hidden]{
   visibility:visible;
</style>
@endsection
<?php $page_title = 'Register New Member'; ?>
@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- START DEFAULT WIZARD -->
		<div class="block">
			<h4>Default Wizard</h4>
			<form action="" method="post" role="form" class="form-horizontal">
				<div class="wizard show-submit">
					<ul>
						<li>
							<a href="#step-1">
								<span class="stepNumber">1</span>
								<span class="stepDesc">Step 1<br /><small>Login Information</small></span>
							</a>
						</li>
						<li>
							<a href="#step-2">
								<span class="stepNumber">2</span>
								<span class="stepDesc">Step 2<br /><small>Personal Information</small></span>
							</a>
						</li>
						<li>
							<a href="#step-3">
								<span class="stepNumber">3</span>
								<span class="stepDesc">Step 3<br /><small>Contact Information</small></span>
							</a>
						</li>
						<li>
							<a href="#step-4">
								<span class="stepNumber">4</span>
								<span class="stepDesc">Step 4<br /><small>Address Information</small></span>
							</a>
						</li>
						<li>
							<a href="#step-5">
								<span class="stepNumber">5</span>
								<span class="stepDesc">Step 5<br /><small>Bank Account Information</small></span>
							</a>
						</li>
						<li>
							<a href="#step-6">
								<span class="stepNumber">6</span>
								<span class="stepDesc">Step 6<br /><small>Beneficiary Info (OPTIONAL)</small></span>
							</a>
						</li>
						<li>
							<a href="#step-7">
								<span class="stepNumber">7</span>
								<span class="stepDesc">Step 7<br /><small>Step 7 description</small></span>
							</a>
						</li>
						<li>
							<a href="#step-8">
								<span class="stepNumber">8</span>
								<span class="stepDesc">Step 8<br /><small>Step 8 description</small></span>
							</a>
						</li>
					</ul>
					
					<div id="step-1">
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Country *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="country" class="form-control">
										<option value="MALAYSIA">MALAYSIA</option>
										<option value="THAILAND">THAILAND</option>
										<option value="SINGAPORE">SINGAPORE</option>
										<option value="INDONESIA">INDONESIA</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Username *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="username" value="{{ old('name')}}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Password *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
									<input class="form-control" type="password" name="password" id="pass1">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Re-Type Password *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
									<input class="form-control" type="password" name="password_confirmation" onkeyup="checkPass(); return false;" id="pass2">
								</div>
								<span id="confirmMessage" class="confirmMessage"></span>
							</div>
						</div>
					</div><!-- END Step 1-->
					<div id="step-2">
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Type *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="type" class="form-control">
										<option value="PERSONAL">PERSONAL</option>
										<option value="BUSINESS">BUSINESS</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Rank *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="rank" class="form-control">
										@foreach($ranks as $rank)
										
										<option value="{{ $rank->name }}">{{ $rank->name }}</option>
										
										@endforeach
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Name *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="name" id="name" onchange="copyTextValue(this);" value="{{ old('name')}}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Date Of Birth *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control datepicker" value="2014-08-04" type="text" name="dob" value="{{ old('dob') }}">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Gender *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="gender" class="form-control">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Marital Status *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="marital_status" class="form-control">
										<option value="Male">Single</option>
										<option value="Female">Married</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Race *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="race" class="form-control">
										<option value="Malay">Malay</option>
										<option value="Chinese">Chinese</option>
										<option value="Indian">Indian</option>
										<option value="Others">Others</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">ID Type *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<select name="id_type" class="form-control">
										<option value="ic">IC</option>
										<option value="passport">Passport</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">ID No *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<input class="form-control" type="text" name="id_no" value="{{ old('id_no') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Upload ID</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<input type="file" multiple id="file-simple" name="id_pic" value="{{ old('id_pic') }}" />
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Introducer *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<input class="form-control" type="text" name="introducer" value="{{ Auth::guard('admin')->user()->username }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
					</div><!-- END Step 2-->
					<div id="step-3">
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Mobile No *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="mobile_no" value="{{ old('mobile_no') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Email *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
									<input class="form-control" type="text" name="email" value="{{ old('email') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
					</div><!-- END Step 3-->
					<div id="step-4">
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Street *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="street" value="{{ old('street') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">City *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="city" value="{{ old('city') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Postcode *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="postcode" value="{{ old('postcode') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">State *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="state" value="{{ old('state') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
					</div><!-- END Step 4-->
					<div id="step-5">
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Bank *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<select name="bank" class="form-control">
										@foreach($banks as $bank)
										
										<option value="{{ $bank->name }}" {{ old('bank') == $bank->name ? ' selected="selected"' : ''}}>
											{{ $bank->name }}
										</option>
										
										@endforeach
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Account No *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="account_no" value="{{ old('account_no') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Account Holder Name *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="acc_holder_name" id="acc_holder_name" value="{{ old('acc_holder_name') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
							<div class="checkbox pull-left">
								<label><input type="checkbox" name="check1" onchange="copyTextValue(this);"> Same As Above</label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Account Type *</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="account_type" value="{{ old('account_type') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
					</div><!-- END Step 5-->
					<div id="step-6">
						<h4>Step 6 Beneficiary</h4>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Beneficiary Name</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="beneficiary_name" value="{{ old('beneficiary_name') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Relationship</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<select name="relationship" class="form-control">
										<option value="Parent" {{ old('relationship') == 'Parent' ? ' selected="selected"' : ''}}>Parent</option>
										<option value="Spouse" {{ old('relationship') == 'Spouse' ? ' selected="selected"' : ''}}>Spouse</option>
										<option value="Sibling" {{ old('relationship') == 'Sibling' ? ' selected="selected"' : ''}}>Sibling</option>
										<option value="Cousin" {{ old('relationship') == 'Cousin' ? ' selected="selected"' : ''}}>Cousin</option>
										<option value="Nephew/Niece" {{ old('relationship') == 'Nephew/Niece' ? ' selected="selected"' : ''}}>Nephew/Niece</option>
										<option value="Uncle/Aunt" {{ old('relationship') == 'Uncle/Aunt' ? ' selected="selected"' : ''}}>Uncle/Aunt</option>
										<option value="Grandparent" {{ old('relationship') == 'Grandparent' ? ' selected="selected"' : ''}}>Grandparent</option>
										<option value="Grandchild" {{ old('relationship') == 'Grandchild' ? ' selected="selected"' : ''}}>Grandchild</option>
										<option value="Friend" {{ old('relationship') == 'Friend' ? ' selected="selected"' : ''}}>Friend</option>
										<option value="Others" {{ old('relationship') == 'Other' ? ' selected="selected"' : ''}}>Others</option>
									</select>
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Address</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="beneficiary_address" value="{{ old('beneficiary_address') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 col-xs-12 control-label">Beneficiary Mobile No</label>
							<div class="col-md-6 col-xs-12">
								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input class="form-control" type="text" name="beneficiary_mobile_no" value="{{ old('beneficiary_mobile_no') }}">
								</div>
								{{-- <span class="help-block">This is sample of text field</span> --}}
							</div>
						</div>
					</div><!-- END Step 6-->
					<div id="step-7">
						<div class='row' style="padding-left:150px; ">
							<h2>Products</h2>
							@php $i = 0; @endphp
							@foreach($products as $product)
							<div class="checkbox">
								<input type="checkbox">
								<div class="pid-{{$product->id}}">
									<input type="text" value="{{$product->name}}" disabled>
									<input type="text" id="price{{$product->id}}" value="{{$product->wm_price}}" disabled>
									<input type="text" id="qty{{$product->id}}"  target="hidden" name="quantity[]" value="0" onblur="calculate()">
									<input type="text" id="subtotal{{$product->id}}" target="hidden" name="subtotal[]" data-ac="(#price{{$product->id}} * #qty{{$product->id}})" >
								</div><br/>
							</div>
							@endforeach	
						
							<h2>Packages</h2>
							@php $i = 0; @endphp
							@foreach($packages as $package)
							<div class="checkbox">
								<input type="checkbox">
								<div class="pid-{{$package->id}}">
									<input type="text" value="{{$package->name}}" disabled>
									<input type="text" id="price{{$package->id}}" value="{{$package->wm_price}}" disabled>
									<input type="text" id="qty{{$package->id}}"  target="hidden" name="quantity[]" value="0" onblur="calculate()">
									<input type="text" id="subtotal{{$package->id}}" target="hidden" name="subtotal[]" data-ac="(#price{{$package->id}} * #qty{{$package->id}})" >
								</div><br/>
							</div>
							@endforeach	
						</div>
					</div><!-- END Step 7-->
					<div id="step-8">
						<h4>Step 8 Content</h4>
						<p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>
					</div><!-- END Step 8-->
				</div>
			</form>
		</div>
		<!-- END DEFAULT WIZARD -->
	</div><!--END col-md-12 -->
</div><!--END ROW -->
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

<script type='text/javascript' src="{{ asset('themes/Joli/js/plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/smartwizard/jquery.smartWizard-2.0.min.js')}}"></script>        
<script type="text/javascript" src="{{ asset('themes/Joli/js/plugins/jquery-validation/jquery.validate.js')}}"></script>
<!-- END THIS PAGE PLUGINS -->  

<script>
    $(function(){
        $("#file-simple").fileinput({
                showUpload: false,
                showCaption: false,
                browseClass: "btn btn-danger",
                fileType: "any"
        });            
        function(file) {
            alert(file);
        }, function(dir){
            setTimeout(function(){
                page_content_onresize();
            },200);                    
        });                
    });            
</script>
{{-- Copy Value of Name to Account Holde Name field if check box same as above is ticked--}}
<script>    
function copyTextValue(bf) {
    var text1 = bf.checked ? document.getElementById("name").value : '';
    document.getElementById("acc_holder_name").value = text1;
}
</script>

{{-- Check Matching Password --}}
<script type="text/javascript">
	function checkPass()
	{
	    //Store the password field objects into variables ...
	    var pass1 = document.getElementById('pass1');
	    var pass2 = document.getElementById('pass2');
	    //Store the Confimation Message Object ...
	    var message = document.getElementById('confirmMessage');
	    //Set the colors we will be using ...
	    var goodColor = "#66cc66";
	    var badColor = "#ff6666";
	    //Compare the values in the password field 
	    //and the confirmation field
	    if(pass1.value == pass2.value){
	        //The passwords match. 
	        //Set the color to the good color and inform
	        //the user that they have entered the correct password 
	        pass2.style.backgroundColor = goodColor;
	        message.style.color = goodColor;
	        message.innerHTML = "Passwords Match!"
	    }else{
	        //The passwords do not match.
	        //Set the color to the bad color and
	        //notify the user.
	        pass2.style.backgroundColor = badColor;
	        message.style.color = badColor;
	        message.innerHTML = "Passwords Do Not Match!"
	    }
	}  
</script>
<script>
	(function($) {
    $.fn.jlac = function(opt, callback) {
        if ($(this).length > 0) {
            $(this).each(function() {
                var t = $(this);
                t.attr('data-acinitialized', true);
                var stn = $.fn.jlac.defaults;
                stn.callback = callback;
                stn = $.extend(stn, opt);
                var expression = $(this).attr('data-ac');
                var statementsarray = $(this).attr('data-ac').split(/{|}/);
                var expressionelements = expression.replace(/[\(\)\+\-\*\/\%\|]/g, ',');
                expressionelements = expressionelements.replace(/\{.*?\}/g, '');
                expressionelements = expressionelements.replace(/,,+/g, ',')
                expressionelements = stn.trim(',', expressionelements);
                $('body').on(stn.event,expressionelements,function(e) {
                    var output = "";

                    t.trigger('beforeautocalculate', output);
                    $.each(statementsarray,function (si, s) {
                        var total = s;

                        var subexpression = s;
                        var subexpressionelements = subexpression.replace(/[\(\)\+\-\*\/\%]/g, ',');
                       // subexpressionelements = subexpressionelements.replace(/\{.*?\}/g, '');



                        subexpressionelements = subexpressionelements.replace(/,,/g, '');
                        subexpressionelements = stn.trim(',', subexpressionelements)

                        var elementsarray = subexpressionelements.split(',');
                        try {
                            /*each*/
                            if ($(subexpressionelements).length > 0) {
                                $(subexpressionelements).each(function(ei, v) {
                                    var value = 0;
                                    try {
                                        value = ($(this).val())
                                            ? parseFloat($(this).val()).toString() != 'NaN'
                                            ? parseFloat($(this).val())
                                            : 0
                                            : 0;
                                        if (value == 0) {
                                            value = ($(this).text())
                                            ? parseFloat($(this).text()).toString() != 'NaN'
                                            ? parseFloat($(this).text())
                                            : 0
                                            : 0;
                                        }

                                    } catch (e) {
                                    }
                                    if (((value)) || value == 0) {
                                        total = total.replace(elementsarray[ei], value);
                                    }
                                });
                                total = eval(total).toFixed(stn.fixedto);
                            }
                        } catch (e) {

                        }
                        /*each ends*/


                        output += total;
                    });
                    t.trigger('keyup', output);
                    t.trigger('afterautocalculate', output);
                    t.val(output);
                    t.text(output);
                    if (callback) {
                        callback(output);
                    }
                });

                $(expressionelements).trigger('keyup');
            });
        }
        return this;
    };
    $.fn.jlac.defaults = {
        event: "keyup blur change",
        fixedto:2,
        trim: function(char, str) {
            if (str.slice(0, char.length) === char) {
                str = str.substr(1);
            }
            if (str.slice(str.length - char.length) === char) {
                str = str.slice(0, -1);;
            }
            return str;
        }
    }
    $(document).ready(function() {
        $('[data-ac]').jlac();
        $(document).on('DOMNodeInserted',
            function(event) {
                $('[data-ac]:not("[data-acinitialized]")').jlac();

            });
    });
})(jQuery);
</script>

@stop


                    
                    
