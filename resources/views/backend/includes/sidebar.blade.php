<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('/')}}backend-assets/images/last_png.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">MetaSoft BD</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li >
            <a href="{{ url('/') }}" class="">
                <div class=""><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        
        <li class="menu-label">Home</li>

        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-package'></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li class="m-0"> <a href="{{ url('products') }}"><i class="bx bx-package"></i>Products</a>
                </li>
                <li class="m-0"> <a href="{{ url('categories') }}" class="text-color-white"><i class="bx bx-category"></i>Category</a>
                </li>
                <li class="m-0"> <a href="{{ url('variants') }}"><i class="bx bx-revision"></i>Variant</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-basket'></i>
                </div>
                <div class="menu-title">Order</div>
            </a>
            <ul>
                <li class="m-0"> <a href="{{ url('customers') }}"><i class="bx bx-group"></i>Customers</a>
                </li>
                <li class="m-0"> <a href="{{ url('orders') }}"><i class="bx bx-cart"></i>Orders</a>
                </li>
                <li> <a href="{{ url('inventory') }}"><i class="bx bx-right-arrow-alt"></i>Inventory</a>
                </li> 
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-money'></i>
                </div>
                <div class="menu-title">Accounts</div>
            </a>
            <ul>
                <li class="m-0"> <a href="{{ url('expenses') }}"><i class="bx bx-wallet"></i>Expense</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-info-circle'></i>
                </div>
                <div class="menu-title">My Pages</div>
            </a>
            <ul>
                <li class="m-0">
                    <a href="{{ route('settings.edit', ['section' => 'header']) }}"><i class="bx bx-globe"></i>Website</a>
                </li>
                <li class="m-0"> <a href="{{ url('/website-checkout') }}"><i class="bx bx-cart"></i>Check-Out</a>
                </li>
                <!-- <li class="m-0"> <a href="{{ url('/customer-review') }}"><i class="bx bx-star"></i>Review</a>
                </li> -->
            </ul>
        </li>
        

        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-cog'></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                <li class="m-0"> <a href="{{ url('/delivery-partners') }}"><i class="bx bx-car"></i>Delivery Partners</a>
                </li>
                <li class="m-0"> <a href="{{ url('/delivery_charges') }}"><i class="bx bx-credit-card"></i>Delivery Charges</a>
                </li>
                <li class="m-0"> <a href="{{ url('/store_information') }}"><i class="bx bx-store"></i>Store Information</a>
                </li>
                <li class="m-0"> <a href="{{ url('/domain') }}"><i class="bx bx-link"></i>Domain</a>
                </li>
                <li class="m-0"> <a href="{{ url('/policies') }}"><i class="bx bx-file"></i>Policies</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-file'></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>
            <ul>
                <li class="m-0"> <a href="{{ url('sales-report') }}"><i class="bx bx-line-chart"></i>Sales Report</a></li>
                <li class="m-0"> <a href="{{ url('stock-report') }}"><i class="bx bx-line-chart"></i>Stock Report</a></li>
                <li class="m-0"> <a href="{{ url('product-performance') }}"><i class="bx bx-line-chart"></i>Product Performance Report</a></li>
                <li class="m-0"> <a href="{{ url('customer-report') }}"><i class="bx bx-line-chart"></i>Customer Report</a></li>
                <li class="m-0"> <a href="{{ url('financial-report') }}"><i class="bx bx-line-chart"></i>Financial Report</a></li>
            </ul>
        </li>
        <li >
            <a href="{{ url('/product-source') }}" class="">
                <div class=""><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Product Source</div>
            </a>
        </li>
        <li >
            <a href="{{ url('/reference') }}" class="">
                <div class=""><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Referral Bonus</div>
            </a>
        </li>

        
         {{-- Only show Admin section for Admin --}}
         @php $user = Auth::user(); @endphp
         @if($user && $user->role && in_array($user->role->name, ['Admin']))
            <li class="menu-label">Admin</li>
            <li>
            <a href="{{ url('users') }}">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Users</div>
            </a>
        </li>
        <li>
            <a href="{{ url('roles') }}">
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Role & Permission</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow radius-top-8">
                <div class="parent-icon"><i class='bx bx-file'></i>
                </div>
                <div class="menu-title">Subscription & Billing</div>
            </a>
            <ul>
                <li class="m-0"> <a ><i class="bx bx-line-chart"></i>Subscription & Billing</a></li>
                <li class="m-0"> <a href="{{ url('bonus') }}"><i class="bx bx-line-chart"></i>Referral Bonus</a></li>
            </ul>
        </li>
        <li>
            <a>
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Team/Staff</div>
            </a>
        </li>
        <li>
            <a>
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Support System</div>
            </a>
        </li>
        <li>
            <a>
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Domain Request</div>
            </a>
        </li>
        <li>
            <a>
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Product Request</div>
            </a>
        </li>
        <li>
            <a>
                <div class="parent-icon"><i class="bx bx-user-circle"></i>
                </div>
                <div class="menu-title">Accounting & Finance</div>
            </a>
        </li>
        @endif
    </ul>
    <!--end navigation-->
</div>
