@php
    $searchQuery = request()->input();

    if ($searchQuery && ! empty($searchQuery)) {
        $searchQuery = implode('&', array_map(
            function ($v, $k) {
                if (is_array($v)) {
                    if (is_array($v)) {
                        $key = array_keys($v)[0];

                        return $k. "[$key]=" . implode('&' . $k . '[]=', $v);
                    } else {
                        return $k. '[]=' . implode('&' . $k . '[]=', $v);
                    }
                } else {
                    return $k . '=' . $v;
                }
            },
            $searchQuery,
            array_keys($searchQuery)
        ));
    } else {
        $searchQuery = false;
    }
@endphp

{!! view_render_event('bagisto.shop.layout.header.locale.before') !!}
    <div class="header-dropdown mr-auto">
        <!-- <div class="locale-icon"> -->
            @if ($currentLocaleImageSource = app(\Webkul\Velocity\Helpers\Helper::class)->getCurrentLocaleImageSource())
                <!-- <img src="{{ $currentLocaleImageSource }}" alt="" width="20" height="20" /> -->
            @endif
        <!-- </div> -->
        <a href="?locale={{ app()->getLocale() }}" class="pl-0">
            <i class="flag-{{ app()->getLocale() }} flag"></i>{{ app()->make('translator')->getLocale() }}
        </a>
        <div class="header-menu">
            <ul>
                @foreach (core()->getCurrentChannel()->locales as $locale)
                    @if (isset($searchQuery) && $searchQuery)
                        <li><a href="?{{ $searchQuery }}&locale={{ $locale->code }}"><i class="flag-{{ $locale->code }} flag mr-2"></i>{{ $locale->name }}</a></li>
                    @else
                        <li><a href="?locale={{ $locale->code }}"><i class="flag-{{ $locale->code }} flag mr-2"></i>{{ $locale->name }}</a></li>
                    @endif
                @endforeach
                <!-- <li><a href="#"><i class="flag-us flag mr-2"></i>ENG</a>
                </li>
                <li><a href="#"><i class="flag-fr flag mr-2"></i>FRA</a></li> -->
            </ul>
        </div><!-- End .header-menu -->
    </div><!-- End .header-dropown -->

{!! view_render_event('bagisto.shop.layout.header.locale.after') !!}
