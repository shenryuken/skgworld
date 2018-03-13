@extends('layouts.joli.app')
    <?php $page_title = 'Register New Member'; ?>
@section('content')
<div class="col-md-12">
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
  <form class="form-horizontal" method="post" action="{{ url('admin/register-member') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <div class="panel panel-default">
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Login Info</strong></h3>
      </div>
      <div class="panel-body">
        
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
      
      <!-- Personal Information -->
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Personal Information</strong></h3>
      </div>
      <div class="panel-body">
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
      
      
      {{-- <div class="panel-footer">
        <button class="btn btn-default">Clear Form</button>
        <button class="btn btn-primary pull-right">Submit</button>
      </div> --}}
      <!-- END Personal Information -->
      <!-- Contact Info -->
      
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Contact Info</strong></h3>
      </div>
      <div class="panel-body">
        
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
      <!--end Contact Info -->
      <!-- Address Info -->
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Address Info</strong></h3>
      </div>
      <div class="panel-body">
        
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
      <!--END Address Info -->
      <!-- Bank Account Info -->
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Bank Account Info</strong></h3>
      </div>
      <div class="panel-body">
        
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
      <!--END Bank Account -->
      <!-- Beneficiary Info -->
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Beneficiary Info (OPTIONAL)</strong></h3>
      </div>
      <div class="panel-body">
        
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
      <!--END Bank Account -->
      <!-- Security Info -->
      <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title"><strong>Security</strong></h3>
      </div>
      <div class="panel-body">
        
        <div class="form-group">
          <label class="col-md-3 col-xs-12 control-label">Security Code *</label>
          <div class="col-md-6 col-xs-12">
            <div class="input-group">
              <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
              <input class="form-control" type="password" name="security_code" placeholder="Security Code Here">
            </div>
            {{-- <span class="help-block">This is sample of text field</span> --}}
          </div>
        </div>
      </div>
      <!--END Security Info -->
      <div class="panel-footer">
        {{-- <button class="btn btn-default">Clear Form</button> --}}
        <button class="btn btn-primary pull-right">Submit</button>
      </div>
    </div>
    
  </form>
  
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
<script>
$(function(){
$("#file-simple").fileinput({
showUpload: false,
showCaption: false,
browseClass: "btn btn-danger",
fileType: "any"
});
$("#filetree").fileTree({
root: '/',
script: 'assets/filetree/jqueryFileTree.php',
expandSpeed: 100,
collapseSpeed: 100,
multiFolder: false
}, function(file) {
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
<!-- END SCRIPTS -->
@stop