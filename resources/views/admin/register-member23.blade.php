@extends('layouts.joli.app')
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
                                                          

                </div>
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

                </div>                      
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
                </div>
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
                </div>   
                <div id="step-5">   
                    <div class="form-group">
			          <label class="col-md-3 col-xs-12 control-label">Bank *</label>
			          <div class="col-md-6 col-xs-12">
			            <div class="input-group">
			              <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
			              <select name="bank" class="form-control">
			                @foreach($banks as $bank)
			                  
			                  <option value="{{ $bank->name }}" {{ old('bank') == $bank->name ? ' selected="selected"' : ''}}>{{ $bank->name }}</option>
			                  
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
                </div>
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
			     
                </div>                      
                <div id="step-7">
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
					                <form action="{{url('shop/addToCart')}}" method="post">
										{{ csrf_field() }}
										<input type="hidden" name="itemType" value="product">
										<input type="hidden" name="id" value="{{ $product->id }}">
										<div class="col-md-3">
											<div class="form-group">
								                <label>Quantity</label>
								                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="quantity">
								                @for($i = 1; $i <= 100; $i++)
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
					
                </div>
                <div id="step-8">
                    <h4>Step 8 Content</h4>
                    <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>
                </div>   
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


@stop