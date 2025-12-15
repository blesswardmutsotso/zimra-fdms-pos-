<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MyPOS | @yield('title', 'Dashboard')</title>

    <!-- Fonts & Icons -->
    <link href="{{ asset('ui/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- SB Admin 2 -->
    <link href="{{ asset('ui/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .bg-gradient-primary {
            background-color: #1cc88a !important;
            background-image: linear-gradient(180deg, #1cc88a 10%, #13855c 100%) !important;
            background-size: cover;
        }

        /* Adjust main content for fixed topbar */
#content-wrapper {
    margin-top: 70px; /* height of the navbar */
}

/* Optional: keep sidebar full height */
#accordionSidebar {
    position: fixed;
    height: 100%;
}


    /* Sidebar Green Theme */
    .bg-gradient-primary {
        background-color: #1cc88a !important;
        background-image: linear-gradient(180deg, #1cc88a 10%, #13855c 100%) !important;
        background-size: cover;
    }

    /* Fixed sidebar */
    #accordionSidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        overflow-y: auto;
    }

    /* Content wrapper offset */
    #content-wrapper {
        margin-left: 250px; /* Sidebar width */
        padding-top: 70px; /* Navbar height */
    }

    /* Topbar fixed only inside content area */
    #topbar {
        position: fixed;
        top: 0;
        left: 250px; /* Start after sidebar */
        width: calc(100% - 250px); /* Full width minus sidebar */
        z-index: 1030;
    }
</style>
    

    
</head>
<body id="page-top">

<div id="wrapper">

    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.topbar')

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto text-center">
                <span>Copyright © MyPOS {{ date('Y') }}</span>
            </div>
        </footer>
    </div>

</div>

<script src="{{ asset('ui/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('ui/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('ui/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('ui/js/sb-admin-2.min.js') }}"></script>

@stack('scripts')
</body>
</html>
