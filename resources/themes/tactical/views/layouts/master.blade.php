<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        {{-- title --}}
        <title>@yield('page_title')</title>

        {{-- meta data --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url()->to('/') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        {!! view_render_event('bagisto.shop.layout.head') !!}

        {{-- for extra head data --}}
        @yield('head')

        {{-- seo meta data --}}
        @section('seo')
            <meta name="description" content="{{ core()->getCurrentChannel()->description }}"/>
        @show

        {{-- fav icon --}}
        @if ($favicon = core()->getCurrentChannel()->favicon_url)
            <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('/themes/velocity/assets/images/static/v-icon.png') }}" />
        @endif

        {{-- all styles --}}
        @include('shop::layouts.styles')
    </head>

    <body @if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        {{-- main app --}}

        <div id="app" class="page-wrapper">
            <product-quick-view v-if="$root.quickView"></product-quick-view>

            <header class="header">
                @section('body-header')
                    {{-- top nav which contains currency, locale and login header --}}
                    @include('shop::layouts.header-top.index')

                    {!! view_render_event('bagisto.shop.layout.header.before') !!}

                        {{-- primary header after top nav --}}
                        @include('shop::layouts.header-middle.index')

                    {!! view_render_event('bagisto.shop.layout.header.after') !!}
                @show
            </header>

            @yield('content-wrapper')

            <main class="main">
                {!! view_render_event('bagisto.shop.layout.full-content.before') !!}

                    @yield('full-content-wrapper')

                {!! view_render_event('bagisto.shop.layout.full-content.after') !!}
            </main>
        </div>

        {{-- footer --}}
        @section('footer')
            {!! view_render_event('bagisto.shop.layout.footer.before') !!}

                @include('shop::layouts.footer.index')

            {!! view_render_event('bagisto.shop.layout.footer.after') !!}
        @show

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        {{-- alert container --}}
        <div id="alert-container"></div>

        <div class="loading-overlay">
            <div class="bounce-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>

        <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

        @yield('newsletter')

        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

        {{-- all scripts --}}
        @include('shop::layouts.scripts')
    </body>
</html>
