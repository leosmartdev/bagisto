<?php

namespace Webkul\Marketplace\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Marketplace\Repositories\SellerRepository;
use Webkul\Marketplace\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductRepository as CoreProductRepository;
use Cart as CartFacade;

/**
 * Cart event handler
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Cart
{
    /**
     * SellerRepository object
     *
     * @var Seller
    */
    protected $sellerRepository;

    /**
     * ProductRepository object
     *
     * @var Product
    */
    protected $productRepository;

    /**
     * CoreProductRepository Object
     */
    protected $coreProductRepository;

    /**
     * Create a new customer event listener instance.
     *
     * @param  Webkul\Marketplace\Repositories\SellerRepository  $sellerRepository
     * @param  Webkul\Marketplace\Repositories\ProductRepository $productRepository
     * @return void
     */
    public function __construct(
        SellerRepository $sellerRepository,
        ProductRepository $productRepository,
        CoreProductRepository $coreProductRepository
    )
    {
        $this->sellerRepository = $sellerRepository;

        $this->productRepository = $productRepository;

        $this->coreProductRepository = $coreProductRepository;
    }

    /**
     * Product added to the cart
     *
     * @param mixed $cartItem
     */
    public function cartItemAddBefore($productId)
    {
        $data = request()->all();

        if (isset($data['seller_info']) && !$data['seller_info']['is_owner']) {
            $sellerProduct = $this->productRepository->find($data['seller_info']['product_id']);
        } else {
            if (isset($data['selected_configurable_option'])) {
                $sellerProduct = $this->productRepository->findOneWhere([
                        'product_id' => $data['selected_configurable_option'],
                        'is_owner' => 1
                    ]);
            } else {
                $sellerProduct = $this->productRepository->findOneWhere([
                        'product_id' => $productId,
                        'is_owner' => 1
                    ]);

            }
        }

        if (!$sellerProduct) {
            return;
        }

        if (! isset($data['quantity']))
            $data['quantity'] = 1;

        $product = $this->coreProductRepository->findOneByField('id', $productId);

            if ($cart = CartFacade::getCart()) {
                $cartItem = $cart->items()->where('product_id', $sellerProduct->product_id)->first();

                if ($cartItem) {
                    if (!$sellerProduct->haveSufficientQuantity($data['quantity']) && $product->haveSufficientQuantity($data['quantity'])) {
                        return;

                    } else if (!$sellerProduct->haveSufficientQuantity($data['quantity'])) {

                        throw new \Exception('Requested quantity not available.');
                    }

                    $quantity = $cartItem->quantity + $data['quantity'];
                } else {
                    $quantity = $data['quantity'];
                }
            } else {
                $quantity = $data['quantity'];
            }

            if (!$sellerProduct->haveSufficientQuantity($quantity) && $product->haveSufficientQuantity($quantity)) {
                return;

            } else if(!$sellerProduct->haveSufficientQuantity($quantity) ) {

                throw new \Exception('Requested quantity not available.');
            }
    }

    /**
     * Product added to the cart
     *
     * @param mixed $cartItem
     */
    public function cartItemAddAfter($cartItem)
    {
        foreach(CartFacade::getCart()->items as $items)
        {
            if (isset($items->additional['seller_info']) && !$items->additional['seller_info']['is_owner']) {
                $product = $this->productRepository->find($items->additional['seller_info']['product_id']);
                if ($product) {
                    $items->price = core()->convertPrice($product->price);
                    $items->base_price = $product->price;
                    $items->custom_price = $product->price;
                    $items->total = core()->convertPrice($product->price * $items->quantity);
                    $items->base_total = $product->price * $items->quantity;

                    $items->save();
                }
                $items->save();
            } else {
                $items->save();
            }
        }
    }
}
