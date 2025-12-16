<nav id="topbar" class="navbar navbar-expand navbar-light bg-white topbar shadow d-flex">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- CENTER DATE & TIME -->
    <div class="mx-auto text-center">
        <span id="currentDateTime"
              class="badge badge-primary px-4 py-2 font-weight-bold"
              style="font-size: 1rem;">
        </span>
    </div>

    <!-- RIGHT SIDE -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name ?? 'MyPOS User' }}
                </span>
                <img class="img-profile rounded-circle"
                     src="{{ asset('ui/img/undraw_profile.svg') }}">
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>

    </ul>
</nav>

<!-- LIVE DATE & TIME SCRIPT -->
<script>
    function updateDateTime() {
        const now = new Date();

        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Africa/Harare'
        };

        document.getElementById('currentDateTime').innerText =
            now.toLocaleString('en-GB', options);
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
