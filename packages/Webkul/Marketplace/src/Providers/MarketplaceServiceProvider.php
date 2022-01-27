<?php

namespace Webkul\Marketplace\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Router;
use \Webkul\Marketplace\Models\Seller;
use Webkul\Core\Tree;

class MarketplaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__ . '/../Http/front-routes.php';

        include __DIR__ . '/../Http/admin-routes.php';

        $this->app->register(ModuleServiceProvider::class);

        $this->app->register(EventServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'marketplace');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'marketplace');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/webkul/marketplace/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/customers/account/partials' => resource_path('themes/default/views/customers/account/partials'),
        ]);

        // $this->publishes([
        //     __DIR__ . '/../Resources/views/shop/default/sellers/products/add-buttons.blade.php' => resource_path('themes/default/views/products/add-buttons.blade.php'),
        // ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/add-buttons.blade.php' => resource_path('themes/default/views/products/add-buttons.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/add-to-cart.blade.php' => resource_path('themes/default/views/products/add-to-cart.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/buy-now.blade.php' => resource_path('themes/default/views/products/buy-now.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/view/stock.blade.php' => resource_path('themes/default/views/products/view/stock.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/view/up-sells.blade.php' => resource_path('themes/default/views/products/view/up-sells.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/view/cross-sells.blade.php' => resource_path('themes/default/views/products/view/cross-sells.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/view/related-products.blade.php' => resource_path('themes/default/views/products/view/related-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/products/list/up-sell-card.blade.php' => resource_path('themes/default/views/products/list/up-sell-card.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/sellers/products/price.blade.php' => resource_path('themes/default/views/products/price.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/admin/customers/edit.blade.php' => resource_path('views/vendor/admin/customers/edit.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/checkout/cart/index.blade.php' => resource_path('themes/default/views/checkout/cart/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/checkout/cart/mini-cart.blade.php' => resource_path('themes/default/views/checkout/cart/mini-cart.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/customers/account/orders/view.blade.php' => resource_path('themes/default/views/customers/account/orders/view.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/home/featured-products.blade.php' => resource_path('themes/default/views/home/featured-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/home/new-products.blade.php' => resource_path('themes/default/views/home/new-products.blade.php'),
        ]);


        //velocity overrided file

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/add-to-cart.blade.php' => resource_path('themes/velocity/views/products/add-to-cart.blade.php')
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/buy-now.blade.php' => resource_path('themes/velocity/views/products/buy-now.blade.php')
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/view/stock.blade.php' => resource_path('themes/velocity/views/products/view/stock.blade.php')
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/customers/account/partials' => resource_path('themes/velocity/views/customers/account/partials'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/customers/account/index.blade.php' => resource_path('themes/velocity/views/customers/account/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/UI' => resource_path('themes/velocity/views/UI'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/sellers/products/add-buttons.blade.php' => resource_path('themes/velocity/views/products/add-buttons.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/sellers/products/price.blade.php' => resource_path('themes/velocity/views/products/price.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/checkout/total/summary.blade.php' => resource_path('themes/velocity/views/checkout/total/summary.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/checkout/cart/mini-cart.blade.php' => resource_path('themes/velocity/views/checkout/cart/mini-cart.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/customers/account/orders/view.blade.php' => resource_path('themes/velocity/views/customers/account/orders/view.blade.php'),
        ]);

         $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/checkout/cart/index.blade.php' => resource_path('themes/velocity/views/checkout/cart/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/checkout/cart/mini-cart.blade.php' => resource_path('themes/velocity/views/checkout/cart/mini-cart.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/home/featured-products.blade.php' => resource_path('themes/velocity/views/home/featured-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/home/new-products.blade.php' => resource_path('themes/velocity/views/home/new-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/view/up-sells.blade.php' => resource_path('themes/velocity/views/products/view/up-sells.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/view/cross-sells.blade.php' => resource_path('themes/velocity/views/products/view/cross-sells.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/view/related-products.blade.php' => resource_path('themes/velocity/views/products/view/related-products.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/products/list/up-sell-card.blade.php' => resource_path('themes/velocity/views/products/list/up-sell-card.blade.php'),
        ]);

        //mobile view icon
        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/UI/header.blade.php' => resource_path('themes/velocity/views/UI/header.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Repositories/Admin/invoiceRepository.php' => __DIR__ .'/../../../Sales/src/Repositories/InvoiceRepository.php',
        ]);

        $this->publishes([
            __DIR__ . '/../Http/Controllers/Shop/ShopController.php' => __DIR__ .'/../../../Velocity/src/Http/Controllers/Shop/ShopController.php',
        ]);

        $this->publishes([
            __DIR__ . '/../Http/Controllers/Shop/Velocity/Controller.php' => __DIR__ .'/../../../Velocity/src/Http/Controllers/Shop/Controller.php',
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/admin/layouts/nav-left.blade.php' => resource_path('views/vendor/admin/layouts/nav-left.blade.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.customer'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }
}