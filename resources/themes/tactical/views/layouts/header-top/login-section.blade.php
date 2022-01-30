@php
    $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
    $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
@endphp

{!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}

    <div class="header-dropdown dropdown-expanded mr-3">
        <div class="header-menu">
            <ul>
                @auth('customer')
                    <li><a href="{{ route('customer.account.index') }}">My Account</a></li>
                @endauth
                <li><a href="{{ route('shop.cms.page', ['slug' => 'about-us']) }}">About Us</a></li>
                <!-- <li><a href="blog.html">Blog</a></li> -->

                {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}

                    @if($showWishlist)

                        <li><a href="{{ route('customer.wishlist.index') }}">My Wishlist</a></li>

                    @endif

                {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}

                {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}

                    @if($showCompare)

                        <li><a href="{{ auth()->guard('customer')->check() ? route('velocity.customer.product.compare') : route('velocity.product.compare') }}">Compare</a></li>

                    @endif

                {!! view_render_event('bagisto.shop.layout.header.compare.after') !!}

                <!-- <li><a href="cart.html">Cart</a></li> -->
                @guest('customer')
                    <li><a href="{{ route('customer.session.index') }}" class="">Log In</a></li>
                @endguest
                @auth('customer')
                    <li><a href="{{ route('customer.session.destroy') }}" class="">Log Out</a></li>
                @endauth
            </ul>
        </div><!-- End .header-menu -->
    </div><!-- End .header-dropown -->

    <span class="separator d-none d-lg-inline-block"></span>

    <div class="social-icons">
        <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
        </a>
        <a href="#" class="social-icon" target="_blank" title="Line">
            <img style="width: 10px;" src="{{ asset('tactical/assets/images/icons/Line.png') }}">
        </a>
        <a href="#" class="social-icon" target="_blank" title="Line">
            <img style="width: 10px;" src="{{ asset('tactical/assets/images/icons/Tiktok.png') }}">
        </a>
        <a href="#" class="social-icon" target="_blank" title="Line">
            <img style="width: 12px;" src="{{ asset('tactical/assets/images/icons/Youtube.png') }}">
        </a>
    </div><!-- End .social-icons -->

{!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}
