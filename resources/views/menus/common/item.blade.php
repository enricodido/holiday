<li class="nav-item @if($active) active @endif">
    <a class="nav-link text-white @if($active) active @endif" href="{{ $route }}">
        <i class="material-icons-round opacity-10">{{$icon}}</i>
        <span class="sidenav-normal  ms-2  ps-1">{{ $label }}</span>
    </a>
</li>
