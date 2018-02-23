<!-- START X-NAVIGATION -->
<ul class="x-navigation">
    <li class="xn-logo">
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
                <div class="profile-data-name">{{ Auth::user()->username}}</div>
                <div class="profile-data-title">{{ Auth::user()->rank->name }}</div>
            </div>
            <div class="profile-controls">
                <a href="{{ url('user/profile/'.Auth::user()->id) }}" class="profile-control-left"><span class="fa fa-info"></span></a>
                @if(!is_null(Auth::user()->profile))
                <a href="{{url('profile/upload-avatar')}}" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                @endif
            </div>
        </div>                                                                        
    </li>                                                                     
    <li class="xn-title">Navigation</li>
    <li>
        <a href="{{ url('user/dashboard')}}">
        	<span class="fa fa-desktop"></span> 
        	<span class="xn-text">Dashboard</span>
       	</a>
    </li>
    
    <li class="xn-openable">
        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Member</span></a>
        <ul>        
            @if(Auth::user()->rank_id > 2)                    
            <li><a href="{{ url('user/register-member')}}">Register New Member</a></li>
            @endif
            <li><a href="{{ url('referrals/hierarchy/'.Auth::user()->id)}}">Org Chart</a></li>
            <li><a href="{{ url('referrals/my-downline')}}">Referrals</a></li>                
        </ul>
    </li> 
    <li class="xn-openable">
        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Order</span></a>
        <ul>                            
            <li><a href="{{ url('orders/my-orders')}}">My Orders</a></li>
            @if(Auth::user()->rank_id > 2)
            <li><a href="#">My Customer Orders</a></li>
            @endif        
        </ul>
    </li> 
    <li class="xn-openable">
        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Invoice</span></a>
        <ul>                            
            <li><a href="{{ url('invoices/my-invoices')}}">My Invoices</a></li>
            <li><a href="{{ url('invoices/my-customer-invoices/'.Auth::user()->id)}}">My Customer Invoices</a></li>          
        </ul>
    </li> 
    <li class="xn-openable">
        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Bonus</span></a>
        <ul>                            
            <li><a href="{{ url('bonus/statement/'.Auth::user()->id)}}">My Bonus Statement</a></li>
            <li><a href="{{ url('bonus/my-bonus-history/'.Auth::user()->id)}}">My Bonus History</a></li>            
        </ul>
    </li> 
    <li class="xn-title">Shopping</li>
    <li class="xn-openable">
        <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Mall</span></a>
        <ul>                            
            <li><a href="{{ url('shop/skg-mall') }}">SKG Mall</a></li>
            <li><a href="{{ url('shop/agents') }}">Agents Stores</a></li>             
        </ul>
    </li>
    <li>
        <a href="{{ route('users.logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('users.logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>                    
</ul>