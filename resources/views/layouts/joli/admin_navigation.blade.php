<!-- START X-NAVIGATION -->
<ul class="x-navigation">
    <li class="xn-logo" >
        <a href="index.html" style="padding-top: 0;background-color: #080a0e;"><img src="{{ asset('themes/Joli/img/skgwrldogo.png') }}"  height="50" width="200" alt="skgworld"></a>
        <a href="#" class="x-navigation-control"></a>
    </li> 
    <li class="xn-profile">
        <a href="#" class="profile-mini">
            <img src="{{ asset('themes/Joli/assets/images/users/avatar.jpg') }}" alt="John Doe">
        </a>
        <div class="profile">
            <div class="profile-image">
                <img src="{{ asset('themes/Joli/assets/images/users/avatar.jpg') }}" alt="John Doe">
            </div>
            <div class="profile-data">
                <div class="profile-data-name">{{ Auth::guard('admin')->user()->username}}</div>
                <div class="profile-data-title">Web Developer/Designer</div>
            </div>
            <div class="profile-controls">
                <a href="{{ url('admin/profile/'.Auth::guard('admin')->user()->id) }}" class="profile-control-left"><span class="fa fa-info"></span></a>
                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
            </div>
        </div>                                                                        
    </li>                                                                     
    <li class="xn-title">Navigation</li>
    <li>
        <a href="{{ url('admin/dashboard')}}">
        	<span class="fa fa-desktop"></span> 
        	<span class="xn-text">Dashboard</span>
       	</a>
    </li>
    <li>
        <a href="{{ url('admin/profile/'. Auth::guard('admin')->user()->id)}}">
        	<span class="fa fa-user"></span> 
        	<span class="xn-text">My Profile</span>
        </a>
    </li>  
    <li class="xn-openable">
        <a href="#" class="arrow"><span class="fa fa-table"></span> <span class="xn-text">Accounts</span></a>
        <ul>                            
            <li><a href="{{ url('banks/')}}"><span class="fa fa-align-justify"></span> Bank List</a></li>
            <li><a href="{{ url('banks/create')}}"><span class="fa fa-sort-alpha-desc"></span> Add New Bank</a></li>                
        </ul>
    </li>  
    <li class="xn-openable">
        <a href="#" class="arrow"><span class="fa fa-table"></span> <span class="xn-text">Staff</span></a>
        <ul>                            
            <li><a href="{{ url('admin/lists')}}"><span class="fa fa-align-justify"></span> Staff List</a></li>
            <li><a href="{{ url('admin/register-staff')}}"><span class="fa fa-sort-alpha-desc"></span> Register New Staff</a></li>                
        </ul>
    </li>   
    <li class="xn-openable">
        <a href="#"><span class="fa fa-table"></span> <span class="xn-text">Member</span></a>
        <ul>                            
            <li><a href="{{ url('user/lists')}}"><span class="fa fa-align-justify"></span> Member List</a></li>
            <li><a href="{{ url('admin/register-member')}}"><span class="fa fa-sort-alpha-desc"></span> Register New Member</a></li>
            <li><a href="{{ url('profile/ic-status-index')}}"><span class="fa fa-sort-alpha-desc"></span> MyKad/Passport Status Index</a></li>   
        </ul>
    </li> 
    <li>
    	<a href="{{ url('invoices/')}}">
    		<span class="fa fa-file-text-o"></span> Invoices
    	</a>
    </li>   
    <li>
    	<a href="{{ url('orders/')}}">
    		<span class="fa fa-file-text-o"></span> Orders
    	</a>
    </li>     
    <li>
    	<a href="{{ url('products')}}">
    		<span class="fa fa-file-text-o"></span> Products
    	</a>
    </li>  
    <li>
        <a href="{{ url('bonus/calculate-end-month-bonus') }}">
            <span class="fa fa-file-text-o"></span> Count Bonus
        </a>
    </li> 
    <li class="xn-openable">
        <a href="#"><span class="fa fa-table"></span> <span class="xn-text">Reports</span></a>
        <ul>                            
            <li><a href="{{ url('reports/members')}}"><span class="fa fa-align-justify"></span> Members</a></li>
            <li class="xn-openable"><a href="#"><span class="fa fa-sort-alpha-desc"></span> Sales</a>
                <ul>
                    <li><a href="{{ url('reports/sales')}}">General</a></li>
                    <li><a href="">By Product</a></li>
                </ul>
            </li>
            <li><a href="{{ url('reports/stocks')}}"><span class="fa fa-sort-alpha-desc"></span> Stocks</a></li>
            <li><a href="{{ url('reports/bonuses')}}"><span class="fa fa-sort-alpha-desc"></span> Bonuses</a></li>   
        </ul>
    </li>  
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>                          
</ul>
