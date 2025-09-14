<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('admin') }}/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">MH Bhat</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('home') }}">
                <div class="parent-icon"><i class="bx bx-category"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="menu-label">Application</li>
        
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-cart-alt"></i>
                </div>
                <div class="menu-title">Purchase</div>
            </a>
            <ul>
                <li> <a href="{{route('purchase.create')}}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
                <li> <a href="{{route('purchase.index')}}"><i class="bx bx-right-arrow-alt"></i>Supplier List</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-cart"></i>
                </div>
                <div class="menu-title">Product</div>
            </a>
            <ul>
                <li> <a href="{{route('product.create')}}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
                <li> <a href="{{route('product.index')}}"><i class="bx bx-right-arrow-alt"></i>Product List</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-user-plus"></i>
                </div>
                <div class="menu-title">Supplier</div>
            </a>
            <ul>
                <li> <a href="{{route('supplier.create')}}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
                <li> <a href="{{route('supplier.index')}}"><i class="bx bx-right-arrow-alt"></i>Supplier List</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="fadeIn animated bx bx-cog"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="{{route('unit.index')}}"><i class="bx bx-right-arrow-alt"></i>Unit List</a></li>
                <li> <a href="{{route('brand.index')}}"><i class="bx bx-right-arrow-alt"></i>Brand List</a></li>
                <li> <a href="{{route('category.index')}}"><i class="bx bx-right-arrow-alt"></i>Category List</a></li>
                </li>
            </ul>
        </li>
        
    </ul>
    <!--end navigation-->
</div>
