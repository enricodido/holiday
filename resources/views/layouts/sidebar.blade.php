<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white text-wrap" aria-controls="ProfileNav" role="button" aria-expanded="false">
                    <img src=" {{ asset('assets/img/team-1.jpg')}}" class="avatar">
                    <span class="nav-link-text ms-2 ps-1">{{ Auth::user()->fullname }}</span>
                </a>
                <div class="collapse" id="ProfileNav" style="">
                    <ul class="nav ">
                        <li class="nav-item">
                                <a class="nav-link text-white " href="javascript:{}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="sidenav-mini-icon"> L </span>
                                    <span class="sidenav-normal  ms-3  ps-1"> Logout </span>
                                </a>
                            <form id="logout-form" action="{{route('logout')}}" method="POST">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0">

            @if(Auth::user()->hasRole(\App\Helpers\Acl::ROLE_SUPERADMIN))
                @include('menus.superadmin')
            @else
                @include('menus.base')
            @endif
        </ul>

    </div>
</aside>
