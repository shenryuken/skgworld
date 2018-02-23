<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="index.html">
                <img src="{{ asset("themes/Homer/images/profile.jpg") }}" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">{{ Auth::guard('admin')->user()->username }}</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Founder of App <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="analytics.html">Analytics</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
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
                <a href="{{ url('admin/dashboard')}}"> <span class="nav-label">Dashboard</span></a>
            </li>
            <li>
                <a href="{{ url('admin/profile/'. Auth::guard('admin')->user()->id)}}"><span class="nav-label">My Profile</span></a>
            </li>
            <li class="">
                <a href="#" aria-expanded="false"><span class="nav-label">Purchase</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="#">From SKG</a></li>
                    <li><a href="#">From Agent</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Staff<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('admin/lists')}}">Staff</a></li>
                    <li><a href="{{ url('admin/register-staff')}}">Register New Staff</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Members<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('user/lists')}}">Members</a></li>
                    <li><a href="{{ url('admin/register-member')}}">Register New Member</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Bonuses<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('bonus') }}">Calculate Bonus</a></li> 
                    <li><a href="{{ url('bonus/bonus-types') }}">Bonus Type</a></li>         
                    <li><a href="{{ url('bonus/history') }}">Bonus History</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Invoices<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('invoices/')}}">Invoices List</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">Orders<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('orders/')}}">Orders List</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#" aria-expanded="false"><span class="nav-label">Inventory Management</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('inventory/product-list') }}">Products</a></li>
                    <li><a href="{{ url('inventory/category-list') }}">Category</a></li>
                    <li><a href="{{ url('inventory/restock-history') }}">Restock History</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#" aria-expanded="false"><span class="nav-label">Suppllier</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                    <li><a href="{{ url('suppliers') }}">Suppliers List</a></li>
                    <li><a href="{{ url('suppliers/create') }}">Add Supplier</a></li>
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
    </div>
</aside>