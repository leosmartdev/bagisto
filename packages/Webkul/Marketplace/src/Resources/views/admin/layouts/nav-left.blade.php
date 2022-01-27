<div class="navbar-left">
    <ul class="menubar">
        @foreach ($menu->items as $menuItem)
            @if(core()->getConfigData('marketplace.settings.general.status') == "0" && $menuItem['key'] == "marketplace")
                <?php continue; ?>

            @else
                <li class="menu-item {{ $menu->getActive($menuItem) }}">
                    <a href="{{ count($menuItem['children']) ? current($menuItem['children'])['url'] : $menuItem['url'] }}">
                        <span class="icon {{ $menuItem['icon-class'] }}"></span>

                        <span>{{ trans($menuItem['name']) }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>