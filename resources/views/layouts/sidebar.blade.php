<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MyPOS</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">POS Management</div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Point of Sale</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-box"></i>
            <span>Products</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-warehouse"></i>
            <span>Inventory</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Customers</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Sales Reports</span>
        </a>
    </li>

</ul>

<style>
    /* Make sidebar always fixed */
    #accordionSidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        overflow-y: auto;
    }

    /* Adjust content wrapper to leave space for fixed sidebar */
    #content-wrapper {
        margin-left: 250px;
    }
</style>
