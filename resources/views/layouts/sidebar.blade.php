<ul class="navbar-nav sidebar sidebar-dark shadow-lg" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cash-register fa-lg"></i>
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold">
            MyPOS
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- POS MANAGEMENT -->
    <div class="sidebar-heading text-white-50 mt-3">
        POS Management
    </div>

    @php
        $posUrl = route('pos.hashed', ['hash' => Crypt::encryptString('pos-access')]);
    @endphp

    <li class="nav-item">
        <a class="nav-link" href="{{ $posUrl }}">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Point of Sale</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Products</span>
        </a>
    </li>

    
<li class="nav-item">
    <a class="nav-link" href="{{ route('customers.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Customers</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{ route('sales.index') }}">
        <i class="fas fa-fw fa-file-invoice"></i>
        <span>Sales Reports</span>
    </a>
</li>


    <hr class="sidebar-divider">

    <!-- SETTINGS -->
    <div class="sidebar-heading text-white-50">
        Settings
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('client-details.index') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>System Settings</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('device.index') }}">
            <i class="fas fa-fw fa-microchip"></i>
            <span>Fiscal Device Settings</span>
        </a>
    </li>

</ul>

<!-- Sidebar Styling -->
<style>
    /* Sidebar layout */
    #accordionSidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        overflow-y: auto;
        background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
        z-index: 1030;
    }

    /* Sidebar text */
    #accordionSidebar .nav-link span {
        font-weight: 500;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.95);
    }

    /* Icons */
    #accordionSidebar .nav-link i {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Hover effect */
    #accordionSidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 0.35rem;
    }

    /* Active link */
    #accordionSidebar .nav-item.active > .nav-link {
        background-color: rgba(255, 255, 255, 0.25);
        font-weight: 600;
    }

    /* Content spacing */
    #content-wrapper {
        margin-left: 260px;
    }
</style>
