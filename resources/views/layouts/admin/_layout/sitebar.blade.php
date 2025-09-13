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
                <div class="parent-icon"><i class="lni lni-blogger"></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
            <ul>
                <li> <a href="{{ route('blogs.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                </li>
                <li> <a href="{{ route('blogs.index') }}"><i class="bx bx-right-arrow-alt"></i>Blog List</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('contact.index') }}">
                <div class="parent-icon"><i class="lni lni-phone"></i>
                </div>
                <div class="menu-title">Contact</div>
            </a>
        </li>
        
    </ul>
    <!--end navigation-->
</div>
