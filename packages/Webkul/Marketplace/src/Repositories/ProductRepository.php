<?php

namespace Webkul\Marketplace\Repositories;

use DB;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Product\Repositories\ProductRepository as BaseProductRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Models\ProductAttributeValueProxy;
use Webkul\Product\Models\Product;
use Webkul\Product\Repositories\ProductVideoRepository;
use Webkul\Marketplace\Repositories\ProductVideoRepository as MpVideoRepository;

/**
 * Seller Product Reposotory
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductRepository extends Repository
{
    /**
     * AttributeRepository object
     *
     * @var object
     */
    protected $attribute;

    /**
     * ProductRepository object
     *
     * @var Object
     */
    protected $productRepository;

    /**
     * ProductInventoryRepository object
     *
     * @var object
     */
    protected $productInventoryRepository;

    /**
     * ProductImageRepository object
     *
     * @var Object
     */
    protected $productImageRepository;

    /**
     * ProductVideoRepository instance
     *
     * @var \Webkul\Product\Repositories\productVideoRepository
     */
    protected $productVideoRepository;

    /**
     * SellerRepository object
     *
     * @var Object
     */
    protected $sellerRepository;

    /**
     * ProductVideoRepository instance
     *
     * @var object
     */
    protected $mpVideoRepository;

    /**
     * Create a new repository instance.
     *
     * @param  Webkul\Attribute\Repositories\AttributeRepository      $attribute
     * @param  Webkul\Product\Repositories\ProductRepository          $productRepository
     * @param  Webkul\Product\Repositories\ProductInventoryRepository $productInventoryRepository
     * @param  Webkul\Marketplace\Repositories\ProductImageRepository $productImageRepository
     * @param \Webkul\Product\Repositories\ProductVideoRepository          $productVideoRepository
     * @param  Webkul\Marketplace\Repositories\SellerRepository       $sellerRepository
     * @param  Illuminate\Container\Container                         $app
     * @return void
     */
    public function __construct(
        AttributeRepository $attribute,
        BaseProductRepository $productRepository,
        ProductInventoryRepository $productInventoryRepository,
        ProductImageRepository $productImageRepository,
        ProductVideoRepository $productVideoRepository,
        SellerRepository $sellerRepository,
        MpVideoRepository $mpVideoRepository,
        App $app
    )
    {
        $this->attribute = $attribute;

        $this->productRepository = $productRepository;

        $this->productInventoryRepository = $productInventoryRepository;

        $this->productImageRepository = $productImageRepository;

        $this->productVideoRepository = $productVideoRepository;

        $this->sellerRepository = $sellerRepository;

        $this->mpVideoRepository = $mpVideoRepository;

        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Marketplace\Contracts\Product';
    }

    /**
     * @return mixed
     */
    public function create(array $data)
    {
        Event::dispatch('marketplace.catalog.product.create.before');

        $seller = $this->sellerRepository->findOneByField('customer_id', auth()->guard('customer')->user()->id);

        $sellerProduct = parent::create(array_merge($data, [
                'marketplace_seller_id' => $seller->id,
                'is_approved' => core()->getConfigData('marketplace.settings.general.product_approval_required') ? 0 : 1
            ]));

        foreach ($sellerProduct->product->variants as $baseVariant) {
            parent::create([
                    'parent_id' => $sellerProduct->id,
                    'product_id' => $baseVariant->id,
                    'is_owner' => 1,
                    'marketplace_seller_id' => $seller->id,
                    'is_approved' => core()->getConfigData('marketplace.settings.general.product_approval_required') ? 0 : 1
                ]);
        }

        Event::dispatch('marketplace.catalog.product.create.after', $sellerProduct);

        return $sellerProduct;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        Event::dispatch('marketplace.catalog.product.update.before', $id);

        $sellerProduct = $this->find($id);

        foreach ($sellerProduct->product->variants as $baseVariant) {

            if (! $sellerChildProduct = $this->getMarketplaceProductByProduct($baseVariant->id)) {
                parent::create([
                        'parent_id' => $sellerProduct->id,
                        'product_id' => $baseVariant->id,
                        'is_owner' => 1,
                        'marketplace_seller_id' => $sellerProduct->seller->id,
                        'is_approved' => $sellerProduct->is_approved
                    ]);
            }
        }

        Event::dispatch('marketplace.catalog.product.update.after', $sellerProduct);

        return $sellerProduct;
    }

    /**
     * @return mixed
     */
    public function createAssign(array $data)
    {
        Event::dispatch('marketplace.catalog.assign-product.create.before');

        if (isset($data['seller_id']) && auth()->guard('admin')->user()) {
            $seller = $this->sellerRepository->findOneByField('id', $data['seller_id']);
            unset($data['seller_id']);
        } else if (auth()->guard('customer')->user()) {
            $seller = $this->sellerRepository->findOneByField('customer_id', auth()->guard('customer')->user()->id);
        }

        $sellerProduct = parent::create(array_merge($data, [
                'marketplace_seller_id' => $seller->id,
                'is_approved' => core()->getConfigData('marketplace.settings.general.product_approval_required') ? 0 : 1
            ]));

        if (isset($data['selected_variants'])) {
            foreach ($data['selected_variants'] as $baseVariantId) {
                $sellerChildProduct = parent::create(array_merge($data['variants'][$baseVariantId], [
                        'parent_id' => $sellerProduct->id,
                        'condition' => $sellerProduct->condition,
                        'product_id' => $baseVariantId,
                        'is_owner' => 0,
                        'marketplace_seller_id' => $seller->id,
                        'is_approved' => core()->getConfigData('marketplace.settings.general.product_approval_required') ? 0 : 1
                    ]));

                $this->productInventoryRepository->saveInventories(array_merge($data['variants'][$baseVariantId], [
                        'vendor_id' => $sellerChildProduct->marketplace_seller_id
                    ]), $sellerChildProduct->product);
            }
        }

        $this->productInventoryRepository->saveInventories(array_merge($data, [
                'vendor_id' => $sellerProduct->marketplace_seller_id
            ]), $sellerProduct->product);

        $this->productImageRepository->uploadImages($data, $sellerProduct);

        $this->mpVideoRepository->uploadVideos($data, $sellerProduct);

        Event::dispatch('marketplace.catalog.assign-product.create.after', $sellerProduct);

        return $sellerProduct;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function updateAssign(array $data, $id, $attribute = "id")
    {
        Event::dispatch('marketplace.catalog.assign-product.update.before', $id);

        $sellerProduct = $this->find($id);

        parent::update($data, $id);

        $previousBaseVariantIds = $sellerProduct->variants->pluck('product_id');

        if (isset($data['selected_variants'])) {
            foreach ($data['selected_variants'] as $baseVariantId) {
                $variantData = $data['variants'][$baseVariantId];

                if (is_numeric($index = $previousBaseVariantIds->search($baseVariantId))) {
                    $previousBaseVariantIds->forget($index);
                }

                $sellerChildProduct = $this->findOneWhere([
                        'product_id' => $baseVariantId,
                        'marketplace_seller_id' => $sellerProduct->marketplace_seller_id,
                        'is_owner' => 0
                    ]);

                if ($sellerChildProduct) {
                    parent::update(array_merge($variantData, [
                            'price' => $variantData['price'],
                            'condition' => $sellerProduct->condition
                        ]), $sellerChildProduct->id);

                    $this->productInventoryRepository->saveInventories(array_merge($variantData, [
                            'vendor_id' => $sellerChildProduct->marketplace_seller_id
                        ]), $sellerChildProduct->product);
                } else {
                    $sellerChildProduct = parent::create(array_merge($variantData, [
                            'parent_id' => $sellerProduct->id,
                            'product_id' => $baseVariantId,
                            'condition' => $sellerProduct->condition,
                            'is_approved' => $sellerProduct->id_approved,
                            'is_owner' => 0,
                            'marketplace_seller_id' => $sellerProduct->seller->id,
                        ]));

                    $this->productInventoryRepository->saveInventories(array_merge($variantData, [
                            'vendor_id' => $sellerChildProduct->marketplace_seller_id
                        ]), $sellerChildProduct->product);
                }
            }
        }

        if ($previousBaseVariantIds->count()) {
            $sellerProduct->variants()
                ->whereIn('product_id', $previousVariantIds)
                ->delete();
        }

        $this->productImageRepository->uploadImages($data, $sellerProduct);

        $this->mpVideoRepository->uploadVideos($data, $sellerProduct);

        $this->productInventoryRepository->saveInventories(array_merge($data, [
                'vendor_id' => $sellerProduct->marketplace_seller_id
            ]), $sellerProduct->product);

        Event::dispatch('marketplace.catalog.assign-product.update.after', $sellerProduct);

        return $sellerProduct;
    }

    /**
     * @param integer $sellerId
     * @return Collection
     */
    public function getPopularProducts($sellerId, $pageTotal = 4)
    {
        return app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($sellerId) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                $qb = $query->distinct()
                        ->addSelect('product_flat.*')
                        ->leftJoin('marketplace_products', 'product_flat.product_id', '=', 'marketplace_products.product_id')
                        ->where('product_flat.visible_individually', 1)
                        ->where('product_flat.status', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->whereNotNull('product_flat.url_key')
                        ->where('marketplace_products.marketplace_seller_id', $sellerId)
                        ->where('marketplace_products.is_approved', 1)
                        ->whereIn('product_flat.product_id', $this->getTopSellingProducts($sellerId))
                        ->orderBy('id', 'desc');

                return $qb;
            })->paginate($pageTotal);
    }

    /**
     * Returns top selling products
     *
     * @param integer $sellerId
     * @return mixed
     */
    public function getTopSellingProducts($sellerId)
    {
        $seller = $this->sellerRepository->find($sellerId);

        $result = app('Webkul\Marketplace\Repositories\OrderItemRepository')->getModel()
            ->leftJoin('marketplace_products', 'marketplace_order_items.marketplace_product_id', 'marketplace_products.id')
            ->leftJoin('order_items', 'marketplace_order_items.order_item_id', 'order_items.id')
            ->leftJoin('marketplace_orders', 'marketplace_order_items.marketplace_order_id', 'marketplace_orders.id')
            ->select(DB::raw('SUM(qty_ordered) as total_qty_ordered'), 'marketplace_products.product_id')
            ->where('marketplace_orders.marketplace_seller_id', $seller->id)
            ->where('marketplace_products.is_approved', 1)
            ->whereNull('order_items.parent_id')
            ->groupBy('marketplace_products.product_id')
            ->orderBy('total_qty_ordered', 'DESC')
            ->limit(4)
            ->get();

        return $result->pluck('product_id')->toArray();
    }

    /**
     * Returns the total products of the seller
     *
     * @param Seller $seller
     * @return integer
     */
    public function getTotalProducts($seller)
    {
        return $seller->products()->where('is_approved', 1)->where('parent_id', NULL)->count();
    }

    /**
     * Returns the all products of the seller
     *
     * @param integer $seller
     * @return Collection
     */
    public function findAllBySeller($seller)
    {
        $params = request()->input();

        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($seller, $params) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                $qb = $query->distinct()
                        ->addSelect('product_flat.*')
                        ->join('product_flat as variants', 'product_flat.id', '=', DB::raw('COALESCE(' . DB::getTablePrefix() . 'variants.parent_id, ' . DB::getTablePrefix() . 'variants.id)'))
                        ->leftJoin('product_categories', 'product_categories.product_id', '=', 'product_flat.product_id')
                        ->leftJoin('product_attribute_values', 'product_attribute_values.product_id', '=', 'variants.product_id')
                        ->addSelect(DB::raw('IF( product_flat.special_price_from IS NOT NULL
                            AND product_flat.special_price_to IS NOT NULL , IF( NOW( ) >= product_flat.special_price_from
                            AND NOW( ) <= product_flat.special_price_to, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) , IF( product_flat.special_price_from IS NULL , IF( product_flat.special_price_to IS NULL , IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , IF( NOW( ) <= product_flat.special_price_to, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) ) , IF( product_flat.special_price_to IS NULL , IF( NOW( ) >= product_flat.special_price_from, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) , product_flat.price ) ) ) AS price1'))

                        ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                        ->leftJoin('marketplace_products', 'product_flat.product_id', '=', 'marketplace_products.product_id')
                        ->where('product_flat.visible_individually', 1)
                        ->where('product_flat.status', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->whereNotNull('product_flat.url_key')
                        ->where('marketplace_products.marketplace_seller_id', $seller->id)
                        ->where('marketplace_products.is_approved', 1);

                        $qb->addSelect(DB::raw('(CASE WHEN marketplace_products.is_owner = 0 THEN marketplace_products.price ELSE product_flat.price END) AS price2'));

                $queryBuilder = $qb->leftJoin('product_flat as flat_variants', function($qb) use($channel, $locale) {
                    $qb->on('product_flat.id', '=', 'flat_variants.parent_id')
                        ->where('flat_variants.channel', $channel)
                        ->where('flat_variants.locale', $locale);
                });

                if (isset($params['sort'])) {
                    $attribute = $this->attribute->findOneByField('code', $params['sort']);

                    if ($params['sort'] == 'price') {
                        $qb->orderBy($attribute->code, $params['order']);
                    } else {
                        $qb->orderBy($params['sort'] == 'created_at' ? 'product_flat.created_at' : $attribute->code, $params['order']);
                    }
                }

                // $qb = $qb->where(function($query1) {
                //     foreach (['product_flat', 'flat_variants'] as $alias) {
                //         $query1 = $query1->orWhere(function($query2) use($alias) {
                //             $attributes = $this->attribute->getProductDefaultAttributes(array_keys(request()->input()));

                //             foreach ($attributes as $attribute) {
                //                 $column = $alias . '.' . $attribute->code;

                //                 $queryParams = explode(',', request()->get($attribute->code));

                //                 if ($attribute->type != 'price') {
                //                     $query2 = $query2->where(function($query3) use($column, $queryParams) {
                //                         foreach ($queryParams as $filterValue) {
                //                             $query3 = $query3->orWhere($column, $filterValue);
                //                         }
                //                     });
                //                 } else {
                //                     $query2 = $query2->where($column, '>=', core()      ->convertToBasePrice(current($queryParams)))->where($column, '<=',  core()->convertToBasePrice(end($queryParams)));
                //                 }
                //             }
                //         });
                //     }
                // });

                //brand attribute added code
                $attributeFilters = $this->attribute
                ->getProductDefaultAttributes(array_keys(
                    request()->input()
                ));

                if (count($attributeFilters) > 0) {
                    $qb = $qb->where(function ($filterQuery) use ($attributeFilters) {

                        foreach ($attributeFilters as $attribute) {
                            $filterQuery->orWhere(function ($attributeQuery) use ($attribute) {

                                $column = DB::getTablePrefix() . 'product_attribute_values.' . ProductAttributeValueProxy::modelClass()::$attributeTypeFields[$attribute->type];

                                $filterInputValues = explode(',', request()->get($attribute->code));

                                # define the attribute we are filtering
                                $attributeQuery = $attributeQuery->where('product_attribute_values.attribute_id', $attribute->id);

                                # apply the filter values to the correct column for this type of attribute.
                                if ($attribute->type != 'price') {

                                    $attributeQuery->where(function ($attributeValueQuery) use ($column, $filterInputValues) {
                                        foreach ($filterInputValues as $filterValue) {
                                            if (! is_numeric($filterValue)) {
                                                continue;
                                            }
                                            $attributeValueQuery->orWhereRaw("find_in_set(?, {$column})", [$filterValue]);
                                        }
                                    });

                                } else {
                                    $attributeQuery->where($column, '>=', core()->convertToBasePrice(current($filterInputValues)))
                                        ->where($column, '<=', core()->convertToBasePrice(end($filterInputValues)));
                                }
                            });
                        }

                    });

                    $qb->groupBy('variants.id');
                    $qb->havingRaw('COUNT(*) = ' . count($attributeFilters));
                }

                return $qb->groupBy('product_flat.id');
            })->paginate(isset($params['limit']) ? $params['limit'] : 9);

        return $results;
    }

    /**
     * Search Product by Attribute
     *
     * @return Collection
     */
    public function searchProducts($term)
    {
        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($term) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                return $query->distinct()
                        ->addSelect('product_flat.*')
                        ->where('product_flat.status', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->whereNotNull('product_flat.url_key')
                        ->where('product_flat.name', 'like', '%' . $term . '%')
                        ->orderBy('product_id', 'desc');
            })->paginate(16);

        return $results;
    }

    /**
     * Returns seller by product
     *
     * @param integer $productId
     * @return boolean
     */
    public function getSellerByProductId($productId)
    {
        $product = parent::findOneWhere([
                'product_id' => $productId,
                // 'is_owner' => 1
            ]);

        if (! $product) {
            return;
        }

        return $product->seller;
    }

    /**
     * Returns count of seller that selling the same product
     *
     * @param Product $product
     * @return integer
     */
    public function getSellerCount($product)
    {
        return $this->scopeQuery(function($query) use($product) {
                return $query
                        // ->leftJoin('marketplace_sellers', 'marketplace_sellers.id', 'marketplace_products.marketplace_seller_id')
                        ->where('marketplace_products.product_id', $product->id)
                        ->where('marketplace_products.is_owner', 0)
                        ->where('marketplace_products.is_approved', 1);
                        // ->where('marketplace_sellers.is_approved', 0);
            })->count();
    }

    /**
     * Returns the seller products of the product
     *
     * @param Product $product
     * @return Collection
     */
    public function getSellerProducts($product)
    {
        return $this->findWhere([
                'product_id' => $product->id,
                'is_owner' => 0,
                'is_approved' => 1
            ]);
    }

    /**
     * Returns the seller products of the product id
     *
     * @param integer $productId
     * @param integer $sellerId
     * @return Collection
     */
    public function getMarketplaceProductByProduct($productId, $sellerId = null)
    {
        if ($sellerId) {
            $seller = $this->sellerRepository->find($sellerId);
        } else {
            if (auth()->guard('customer')->check()) {
                $seller = $this->sellerRepository->findOneByField('customer_id', auth()->guard('customer')->user()->id);
            } else {
                return;
            }
        }

        return $this->findOneWhere([
                'product_id' => $productId,
                // 'is_owner' => 1,
                'marketplace_seller_id' => $seller->id,
            ]);
    }
}