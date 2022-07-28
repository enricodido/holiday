<ul class="navbar-nav">

    {!! \App\Helpers\Menu::generateItem(route('home'), \App\Helpers\Acl::PERMISSION_ENV_USERS, __('menu.dashboard'), Route::is('home'),'dashboard') !!}
    @includeWhen(App\Helpers\Helper::permissionTo(\App\Helpers\Menu::$users), 'menus.sections.user',['active' => \App\Helpers\Helper::checkMenuActive(config('menus.user'))])

</ul>
