<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <img src="{{ asset("themes/Homer/images/profile.jpg") }}" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">{{ Auth::user()->username }}</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">{{ Auth::user()->rank->name }} <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="analytics.html">Analytics</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('user/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('user/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>


                <div id="sparkline1" class="small-chart m-t-sm"></div>
                <div>
                    <h4 class="font-extra-bold m-b-xs">
                        $260 104,200
                    </h4>
                    <small class="text-muted">Your income from the last year in sales product X.</small>
                </div>
            </div>
        </div>

        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ url('user/dashboard')}}"> <span class="nav-label">Dashboard</span></a>
            </li>
            <li>
                <a href="{{ url('user/profile/'. Auth::user()->id)}}"><span class="nav-label">My Profile</span></a>
            </li>
            <li>
                <a href="{{ url('wallet/mywallet')}}"><span class="nav-label">My Wallet</span></a>
            </li>
            <li class="">
                <a href="#" aria-expanded="false"><span class="nav-label">Purchase</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('shop/skg-mall') }}">SKG Mall</a></li>
                    <li><a href="{{ url('shop/agents') }}">Agents Store</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#" aria-expanded="false"><span class="nav-label">My Members</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    @if(Auth::user()->rank_id > 2)
                    <li><a href="{{ url('user/register-member')}}">Register New Member</a></li>
                    @endif
                    <li><a href="{{ url('referrals/hierarchy/'.Auth::user()->id)}}">Org Chart</a></li>
                    <li><a href="{{ url('referrals/my-downline')}}">Referrals</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Invoices<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('invoices/my-invoices')}}">My Invoices</a></li>
                    <li><a href="{{ url('invoices/my-customer-invoices/'.Auth::user()->id)}}">My Customer Invoices</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Orders<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('orders/')}}">My Orders</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Bonus<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('bonus/my-bonus-history/'.Auth::user()->id)}})}}">My Bonus History</a></li>
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
    </div>
</aside>