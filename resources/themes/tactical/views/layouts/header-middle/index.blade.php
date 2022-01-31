<div class="header-middle sticky-header">
    <div class="container">
        <div class="header-left">
            <button class="mobile-menu-toggler" type="button">
                <i class="fas fa-bars"></i>
            </button>

            <a href="{{ route('shop.home.index') }}" class="logo">
                <img src="{{ core()->getCurrentChannel()->logo_url ?? asset('tactical/assets/images/logo-black.png') }}" alt="Porto Logo">
            </a>
            <div class = navvar_area>
                <nav class="main-nav">
                    <ul class="menu">
                        <li class="active">
                            <a href="{{ route('shop.home.index') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('shop.home.shop') }}">Categories</a>
                            <div class="megamenu megamenu-fixed-width megamenu-3cols">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="horizontal-scroll-wrapper squares">
                                            <div class = "category_scroll_item">
                                                <a href="#" class="nolink">VARIATION 1</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('shop.home.category') }}">Fullwidth Banner</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Boxed Slider
                                                            Banner</a>
                                                    </li>
                                                    <li><a href="{{ route('shop.home.category') }}">Boxed Image
                                                            Banner</a>
                                                    </li>
                                                    <li><a href="{{ route('shop.home.category') }}">Left Sidebar</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Right Sidebar</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Off Canvas Filter</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Horizontal
                                                            Filter1</a>
                                                    </li>
                                                    <li><a href="{{ route('shop.home.category') }}">Horizontal
                                                            Filter2</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class = "category_scroll_item">
                                                <a href="#" class="nolink">VARIATION 2</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('shop.home.categorylist') }}">List Types</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Ajax Infinite Scroll</a>
                                                    </li>
                                                    <li><a href="{{ route('shop.home.category') }}">3 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">4 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">5 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">6 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">7 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">8 Columns Products</a></li>
                                                </ul>
                                            </div>
                                            <div  class = "category_scroll_item">
                                                <a href="#" class="nolink">VARIATION 2</a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('shop.home.categorylist') }}">List Types</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">Ajax Infinite Scroll</a>
                                                    </li>
                                                    <li><a href="{{ route('shop.home.category') }}">3 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">4 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">5 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">6 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">7 Columns Products</a></li>
                                                    <li><a href="{{ route('shop.home.category') }}">8 Columns Products</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 p-0">
                                        <div class="menu-banner">
                                            <figure>
                                                <img src="{{ asset('tactical/assets/images/menu-banner.jpg') }}" alt="Menu banner"
                                                    width="300" height="300">
                                            </figure>
                                            <div class="banner-content">
                                                <h4>
                                                    <span class="">UP TO</span><br />
                                                    <b class="">50%</b>
                                                    <i>OFF</i>
                                                </h4>
                                                <a href="{{ route('shop.home.shop') }}" class="btn btn-sm btn-dark">SHOP
                                                    NOW</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End .megamenu -->
                        </li>
                        <li>
                            <a href="{{ route('shop.home.product') }}">Products</a>
                            <div class="megamenu megamenu-fixed-width">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">PRODUCT PAGES</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('shop.home.product') }}">SIMPLE PRODUCT</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">VARIABLE PRODUCT</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">SALE PRODUCT</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">FEATURED & ON SALE</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">WITH CUSTOM TAB</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">WITH LEFT SIDEBAR</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">WITH RIGHT SIDEBAR</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">ADD CART STICKY</a></li>
                                        </ul>
                                    </div><!-- End .col-lg-4 -->

                                    <div class="col-lg-4">
                                        <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                        <ul class="submenu">
                                            <li><a href="{{ route('shop.home.product') }}">EXTENDED LAYOUT</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">GRID IMAGE</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">FULL WIDTH LAYOUT</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">STICKY INFO</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">LEFT & RIGHT STICKY</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">TRANSPARENT IMAGE</a>
                                            </li>
                                            <li><a href="{{ route('shop.home.product') }}">CENTER VERTICAL</a></li>
                                            <li><a href="{{ route('shop.home.product') }}">BUILD YOUR OWN</a></li>
                                        </ul>
                                    </div><!-- End .col-lg-4 -->

                                    <div class="col-lg-4 p-0">
                                        <div class="menu-banner menu-banner-2">
                                            <figure>
                                                <img src="{{ asset('tactical/assets/images/menu-banner-1.jpg') }}" alt="Menu banner"
                                                    class="product-promo" width="380" height="790">
                                            </figure>
                                            <i>OFF</i>
                                            <div class="banner-content">
                                                <h4>
                                                    <span class="">UP TO</span><br />
                                                    <b class="">50%</b>
                                                </h4>
                                            </div>
                                            <a href="{{ route('shop.home.shop') }}" class="btn btn-sm btn-warning">HIRE BODYGUARD NOW</a>
                                        </div>
                                    </div><!-- End .col-lg-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .megamenu -->
                        </li>
                        <li>
                            <a href="{{ route('shop.home.category') }}">BRANDS</a>
                        </li>
                        <li>
                            <a href="{{ route('shop.home.promotion') }}">PROMOTIONS</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div><!-- End .header-left -->

        <div class="header-right">
            <div class="header-search header-search-popup header-search-category d-none d-lg-block ml-xl-5">
                <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                <form action="#" method="get">
                    <div class="header-search-wrapper">
                        <input type="search" class="form-control bg-white" name="q" id="q"
                            placeholder="I'm searching for..." required="">
                        <div class="select-custom bg-white">
                            <select id="cat" name="cat">
                                <option value="">All Categories</option>
                            </select>
                        </div><!-- End .select-custom -->
                        <button class="btn bg-white icon-search-3" type="submit"></button>
                    </div><!-- End .header-search-wrapper -->
                </form>
            </div>

            <a href="{{ route('customer.session.index') }}" class="header-icon header-icon-user d-lg-none d-block" title="login"><i class="icon-user-2"></i></a>

            <a href="{{ route('customer.wishlist.index') }}" class="header-icon d-lg-none d-block" title="wishlist"><i class="icon-wishlist-2"></i></a>

            <span class="separator d-lg-inline-block d-none"></span>

            <div class="dropdown cart-dropdown">
                <a href="#" title="Cart" class="dropdown-toggle dropdown-arrow cart-toggle" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <i class="icon-shopping-cart"></i>
                    <span class="cart-count badge-circle">3</span>
                </a>

                <div class="cart-overlay"></div>

                <div class="dropdown-menu mobile-cart">
                    <a href="#" title="Close (Esc)" class="btn-close">×</a>

                    <div class="dropdownmenu-wrapper custom-scrollbar">
                        <div class="dropdown-cart-header">Shopping Cart</div>
                        <!-- End .dropdown-cart-header -->

                        <div class="dropdown-cart-products">
                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="{{ route('shop.home.product') }}">Ultimate 3D Bluetooth Speaker</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        × $99.00
                                    </span>
                                </div><!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="{{ route('shop.home.product') }}" class="product-image">
                                        <img src="{{ asset('tactical/assets/images/products/product-1.jpg') }}" alt="product"
                                            width="80" height="80">
                                    </a>

                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div><!-- End .product -->

                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="{{ route('shop.home.product') }}">Brown Women Casual HandBag</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        × $35.00
                                    </span>
                                </div><!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="{{ route('shop.home.product') }}" class="product-image">
                                        <img src="{{ asset('tactical/assets/images/products/product-2.jpg') }}" alt="product"
                                            width="80" height="80">
                                    </a>

                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div><!-- End .product -->

                            <div class="product">
                                <div class="product-details">
                                    <h4 class="product-title">
                                        <a href="{{ route('shop.home.product') }}">Circled Ultimate 3D Speaker</a>
                                    </h4>

                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">1</span>
                                        × $35.00
                                    </span>
                                </div><!-- End .product-details -->

                                <figure class="product-image-container">
                                    <a href="{{ route('shop.home.product') }}" class="product-image">
                                        <img src="{{ asset('tactical/assets/images/products/product-3.jpg') }}" alt="product"
                                            width="80" height="80">
                                    </a>
                                    <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                </figure>
                            </div><!-- End .product -->
                        </div><!-- End .cart-product -->

                        <div class="dropdown-cart-total">
                            <span>SUBTOTAL:</span>

                            <span class="cart-total-price float-right">$134.00</span>
                        </div><!-- End .dropdown-cart-total -->

                        <div class="dropdown-cart-action">
                            <a href="{{ route('shop.home.cart') }}" class="btn btn-gray btn-block view-cart">View
                                Cart</a>
                            <a href="{{ route('shop.home.checkout') }}" class="btn btn-dark btn-block">Checkout</a>
                        </div><!-- End .dropdown-cart-total -->
                    </div><!-- End .dropdownmenu-wrapper -->
                </div><!-- End .dropdown-menu -->
            </div><!-- End .dropdown -->
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div><!-- End .header-middle -->
