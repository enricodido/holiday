<li class="nav-item">
    <a class="nav-link text-white @if($active) active @endif" data-bs-toggle="collapse" aria-expanded="{{ $active }}" href="#userMenu">
        <span class="material-icons-round">people</span>
        <span class="sidenav-normal  ms-2  ps-1"> @lang('menu.users') <b class="caret"></b></span>
    </a>
    <div class="collapse @if($active) show @endif " id="userMenu">
        <ul class="nav">
            {!! \App\Helpers\Menu::generateItem(route('users.index'), \App\Helpers\Acl::PERMISSION_ENV_USERS, __('user.users'), Route::is('users.*')) !!}
            {!! \App\Helpers\Menu::generateItem(route('roles.index'), \App\Helpers\Acl::PERMISSION_ENV_ROLES, __('role.roles'), Route::is('roles.*')) !!}
        </ul>
    </div>
</li>
