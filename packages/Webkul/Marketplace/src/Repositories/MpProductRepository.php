<?php

namespace Webkul\Marketplace\Repositories;

use Illuminate\Container\Container as App;
use DB;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Webkul\Product\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;
use Webkul\Product\Repositories\ProductAttributeValueRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Repositories\ProductImageRepository;
use Webkul\Product\Repositories\ProductCustomerGroupPriceRepository;
use Webkul\Product\Repositories\ProductVideoRepository;

/**
 * Product Repository
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class MpProductRepository extends Repository
{
    /**
     * AttributeRepository object
     *
     * @var object
     */
    protected $attribute;

    /**
     * AttributeOptionRepository object
     *
     * @var object
     */
    protected $attributeOption;

    /**
     * ProductAttributeValueRepository object
     *
     * @var object
     */
    protected $attributeValue;

    /**
     * ProductFlatRepository object
     *
     * @var object
     */
    protected $productInventory;

    /**
     * ProductImageRepository object
     *
     * @var object
     */
    protected $productImage;

    /**
     * ProductVideoRepository instance
     *
     * @var \Webkul\Product\Repositories\productVideoRepository
     */
    protected $productVideoRepository;

    /**
     * Create a new controller instance.
     *  @param \Webkul\Product\Repositories\ProductVideoRepository     $productVideoRepository
     *
     * @return void
     */
    public function __construct(
        AttributeRepository $attribute,
        AttributeOptionRepository $attributeOption,
        ProductAttributeValueRepository $attributeValue,
        ProductInventoryRepository $productInventory,
        ProductImageRepository $productImage,
        ProductVideoRepository $productVideoRepository,
        App $app
    )
    {
        $this->attribute = $attribute;

        $this->attributeOption = $attributeOption;

        $this->attributeValue = $attributeValue;

        $this->productInventory = $productInventory;

        $this->productImage = $productImage;

        $this->productVideoRepository = $productVideoRepository;

        parent::__construct($app);
    }

    /**->where('product_flat.visible_individually', 1)
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Product\Contracts\Product';
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        //before store of the product
        Event::dispatch('catalog.marketplace.product.create.before');

        $product = $this->model->create($data);

        $nameAttribute = $this->attribute->findOneByField('code', 'status');
        $this->attributeValue->create([
                'product_id' => $product->id,
                'attribute_id' => $nameAttribute->id,
                'value' => 1
            ]);

        if (isset($data['super_attributes'])) {
            $super_attributes = [];

            foreach ($data['super_attributes'] as $attributeCode => $attributeOptions) {
                $attribute = $this->attribute->findOneByField('code', $attributeCode);

                $super_attributes[$attribute->id] = $attributeOptions;

                $product->super_attributes()->attach($attribute->id);
            }

            foreach (array_permutation($super_attributes) as $permutation) {
                $this->createVariant($product, $permutation);
            }
        }

        //after store of the product
        Event::dispatch('catalog.marketplace.product.create.after', $product);

        return $product;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $data['locale'] = app()->getLocale();

        Event::dispatch('catalog.marketplace.product.update.before', $id);

        $product = $this->find($id);

        if ($product->parent_id && $this->checkVariantOptionAvailabiliy($data, $product)) {
            $data['parent_id'] = NULL;
        }

        if (empty($data['new'])) {
            $data['new'] = 0;
        }
        if (empty($data['featured'])) {
            $data['featured'] = 0;
        }
        if (empty($data['visible_individually'])) {
            $data['visible_individually'] = 0;
        }
        if (empty($data['guest_checkout'])) {
            $data['guest_checkout'] = 0;
        }
        if(empty($data['status'])) {
           $data['status'] = 0;
        }

        $product->update($data);

        $attributes = $product->attribute_family->custom_attributes;

        foreach ($attributes as $attribute) {
            if (! isset($data[$attribute->code]) || (in_array($attribute->type, ['date', 'datetime']) && ! $data[$attribute->code]))
                continue;

            if ($attribute->type == 'multiselect' || $attribute->type == 'checkbox') {
                $data[$attribute->code] = implode(",", $data[$attribute->code]);
            }

            if ($attribute->type == 'image' || $attribute->type == 'file') {
                $dir = 'product';
                if (gettype($data[$attribute->code]) == 'object') {
                    $data[$attribute->code] = request()->file($attribute->code)->store($dir);
                } else {
                    $data[$attribute->code] = NULL;
                }
            }

            $attributeValue = $this->attributeValue->findOneWhere([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'channel' => $attribute->value_per_channel ? $data['channel'] : null,
                    'locale' => $attribute->value_per_locale ? $data['locale'] : null
                ]);

            if (! $attributeValue) {
                $this->attributeValue->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'value' => $data[$attribute->code],
                    'channel' => $attribute->value_per_channel ? $data['channel'] : null,
                    'locale' => $attribute->value_per_locale ? $data['locale'] : null
                ]);
            } else {
                $this->attributeValue->update([
                    ProductAttributeValue::$attributeTypeFields[$attribute->type] => $data[$attribute->code]
                    ], $attributeValue->id
                );

                if ($attribute->type == 'image' || $attribute->type == 'file') {
                    Storage::delete($attributeValue->text_value);
                }
            }
        }

        $route = request()->route() ? request()->route()->getName() : "";

        if ($route != 'admin.catalog.products.massupdate') {
            if  (isset($data['categories'])) {
                $product->categories()->sync($data['categories']);
            }

            if (isset($data['up_sell'])) {
                $product->up_sells()->sync($data['up_sell']);
            } else {
                $data['up_sell'] = [];
                $product->up_sells()->sync($data['up_sell']);
            }

            if (isset($data['cross_sell'])) {
                $product->cross_sells()->sync($data['cross_sell']);
            } else {
                $data['cross_sell'] = [];
                $product->cross_sells()->sync($data['cross_sell']);
            }

            if (isset($data['related_products'])) {
                $product->related_products()->sync($data['related_products']);
            } else {
                $data['related_products'] = [];
                $product->related_products()->sync($data['related_products']);
            }

            $previousVariantIds = $product->variants->pluck('id');

            if (isset($data['variants'])) {
                foreach ($data['variants'] as $variantId => $variantData) {
                    if (str_contains($variantId, 'variant_')) {
                        $permutation = [];
                        foreach ($product->super_attributes as $superAttribute) {
                            $permutation[$superAttribute->id] = $variantData[$superAttribute->code];
                        }

                        $this->createVariant($product, $permutation, $variantData);
                    } else {
                        if (is_numeric($index = $previousVariantIds->search($variantId))) {
                            $previousVariantIds->forget($index);
                        }

                        $variantData['channel'] = $data['channel'];
                        $variantData['locale'] = $data['locale'];

                        $this->updateVariant($variantData, $variantId);
                    }
                }
            }

            foreach ($previousVariantIds as $variantId) {
                $this->delete($variantId);
            }

            $this->productInventory->saveInventories($data, $product);

            $this->productImage->uploadImages($data, $product);

            $this->productVideoRepository->uploadVideos($data, $product);

            app(ProductCustomerGroupPriceRepository::class)->saveCustomerGroupPrices($data,
                $product);
        }

        if (isset($data['channels'])) {
            $product['channels'] = $data['channels'];
        }

        Event::dispatch('catalog.marketplace.product.update.after', $product);

        return $product;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        Event::dispatch('catalog.marketplace.product.delete.before', $id);

        parent::delete($id);

        Event::dispatch('catalog.marketplace.product.delete.after', $id);
    }

    /**
     * @param mixed $product
     * @param array $permutation
     * @param array $data
     * @return mixed
     */
    public function createVariant($product, $permutation, $data = [])
    {
        if (! count($data)) {
            $data = [
                    "sku" => $product->sku . '-variant-' . implode('-', $permutation),
                    "name" => "",
                    "inventories" => [],
                    "price" => 0,
                    "weight" => 0,
                    "status" => 1
                ];
        }

        $variant = $this->model->create([
                'parent_id' => $product->id,
                'type' => 'simple',
                'attribute_family_id' => $product->attribute_family_id,
                'sku' => $data['sku'],
            ]);

        foreach (['sku', 'name', 'price', 'weight', 'status'] as $attributeCode) {
            $attribute = $this->attribute->findOneByField('code', $attributeCode);

            if ($attribute->value_per_channel) {
                if ($attribute->value_per_locale) {
                    foreach (core()->getAllChannels() as $channel) {
                        foreach (core()->getAllLocales() as $locale) {
                            $this->attributeValue->create([
                                    'product_id' => $variant->id,
                                    'attribute_id' => $attribute->id,
                                    'channel' => $channel->code,
                                    'locale' => $locale->code,
                                    'value' => $data[$attributeCode]
                                ]);
                        }
                    }
                } else {
                    foreach (core()->getAllChannels() as $channel) {
                        $this->attributeValue->create([
                                'product_id' => $variant->id,
                                'attribute_id' => $attribute->id,
                                'channel' => $channel->code,
                                'value' => $data[$attributeCode]
                            ]);
                    }
                }
            } else {
                if ($attribute->value_per_locale) {
                    foreach (core()->getAllLocales() as $locale) {
                        $this->attributeValue->create([
                                'product_id' => $variant->id,
                                'attribute_id' => $attribute->id,
                                'locale' => $locale->code,
                                'value' => $data[$attributeCode]
                            ]);
                    }
                } else {
                    $this->attributeValue->create([
                            'product_id' => $variant->id,
                            'attribute_id' => $attribute->id,
                            'value' => $data[$attributeCode]
                        ]);
                }
            }
        }
        foreach ($permutation as $attributeId => $optionId) {
            $this->attributeValue->create([
                    'product_id' => $variant->id,
                    'attribute_id' => $attributeId,
                    'value' => $optionId
                ]);
        }

        $this->productInventory->saveInventories($data, $variant);

        return $variant;
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function updateVariant(array $data, $id)
    {
        $variant = $this->find($id);

        $variant->update(['sku' => $data['sku']]);

        foreach (['sku', 'name', 'price', 'weight', 'status'] as $attributeCode) {
            $attribute = $this->attribute->findOneByField('code', $attributeCode);

            $attributeValue = $this->attributeValue->findOneWhere([
                    'product_id' => $id,
                    'attribute_id' => $attribute->id,
                    'channel' => $attribute->value_per_channel ? $data['channel'] : null,
                    'locale' => $attribute->value_per_locale ? $data['locale'] : null
                ]);

            if (! $attributeValue) {
                $this->attributeValue->create([
                        'product_id' => $id,
                        'attribute_id' => $attribute->id,
                        'value' => $data[$attribute->code],
                        'channel' => $attribute->value_per_channel ? $data['channel'] : null,
                        'locale' => $attribute->value_per_locale ? $data['locale'] : null
                    ]);
            } else {
                $this->attributeValue->update([
                    ProductAttributeValue::$attributeTypeFields[$attribute->type] => $data[$attribute->code]
                ], $attributeValue->id);
            }
        }

        $this->productInventory->saveInventories($data, $variant);

        return $variant;
    }

    /**
     * @param array $data
     * @param mixed $product
     * @return mixed
     */
    public function checkVariantOptionAvailabiliy($data, $product)
    {
        $parent = $product->parent;

        $superAttributeCodes = $parent->super_attributes->pluck('code');

        $isAlreadyExist = false;

        foreach ($parent->variants as $variant) {
            if ($variant->id == $product->id)
                continue;

            $matchCount = 0;

            foreach ($superAttributeCodes as $attributeCode) {
                if (! isset($data[$attributeCode]))
                    return false;

                if ($data[$attributeCode] == $variant->{$attributeCode})
                    $matchCount++;
            }

            if ($matchCount == $superAttributeCodes->count()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param integer $categoryId
     * @return Collection
     */
    public function getAll($categoryId = null)
    {
        $params = request()->input();

        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($params, $categoryId) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                $qb = $query->distinct()
                        ->addSelect('product_flat.*')
                        ->addSelect(DB::raw('IF( product_flat.special_price_from IS NOT NULL
                            AND product_flat.special_price_to IS NOT NULL , IF( NOW( ) >= product_flat.special_price_from
                            AND NOW( ) <= product_flat.special_price_to, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) , IF( product_flat.special_price_from IS NULL , IF( product_flat.special_price_to IS NULL , IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , IF( NOW( ) <= product_flat.special_price_to, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) ) , IF( product_flat.special_price_to IS NULL , IF( NOW( ) >= product_flat.special_price_from, IF( product_flat.special_price IS NULL OR product_flat.special_price = 0 , product_flat.price, LEAST( product_flat.special_price, product_flat.price ) ) , product_flat.price ) , product_flat.price ) ) ) AS final_price'))

                        ->leftJoin('products', 'product_flat.product_id', '=', 'products.id')
                        ->leftJoin('product_categories', 'products.id', '=', 'product_categories.product_id')
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->whereNotNull('product_flat.url_key');

                if ($categoryId) {
                    $qb->where('product_categories.category_id', $categoryId);
                }

                if (is_null(request()->input('status'))) {
                    $qb->where('product_flat.status', 1);
                }

                if (is_null(request()->input('visible_individually'))) {
                    $qb->where('product_flat.visible_individually', 1);
                }

                $queryBuilder = $qb->leftJoin('product_flat as flat_variants', function($qb) use($channel, $locale) {
                    $qb->on('product_flat.id', '=', 'flat_variants.parent_id')
                        ->where('flat_variants.channel', $channel)
                        ->where('flat_variants.locale', $locale);
                });

                if (isset($params['search'])) {
                    $qb->where('product_flat.name', 'like', '%' . urldecode($params['search']) . '%');
                }

                if (isset($params['sort'])) {
                    $attribute = $this->attribute->findOneByField('code', $params['sort']);

                    if ($params['sort'] == 'price') {
                        if ($attribute->code == 'price') {
                            $qb->orderBy('final_price', $params['order']);
                        } else {
                            $qb->orderBy($attribute->code, $params['order']);
                        }
                    } else {
                        $qb->orderBy($params['sort'] == 'created_at' ? 'product_flat.created_at' : $attribute->code, $params['order']);
                    }
                }

                $qb = $qb->leftJoin('products as variants', 'products.id', '=', 'variants.parent_id');

                $qb = $qb->where(function($query1) use($qb) {
                    $aliases = [
                            'products' => 'filter_',
                            'variants' => 'variant_filter_'
                        ];

                    foreach($aliases as $table => $alias) {
                        $query1 = $query1->orWhere(function($query2) use($qb, $table, $alias) {

                            foreach ($this->attribute->getProductDefaultAttributes(array_keys(request()->input())) as $code => $attribute) {
                                $aliasTemp = $alias . $attribute->code;

                                $qb = $qb->leftJoin('product_attribute_values as ' . $aliasTemp, $table . '.id', '=', $aliasTemp . '.product_id');

                                $column = ProductAttributeValue::$attributeTypeFields[$attribute->type];

                                $temp = explode(',', request()->get($attribute->code));

                                if ($attribute->type != 'price') {
                                    $query2 = $query2->where($aliasTemp . '.attribute_id', $attribute->id);

                                    $query2 = $query2->where(function($query3) use($aliasTemp, $column, $temp) {
                                        foreach($temp as $code => $filterValue) {
                                            $columns = $aliasTemp . '.' . $column;
                                            $query3 = $query3->orwhereRaw("find_in_set($filterValue, $columns)");
                                        }
                                    });
                                } else {
                                    $query2 = $query2->where($aliasTemp . '.' . $column, '>=', core()->convertToBasePrice(current($temp)))
                                            ->where($aliasTemp . '.' . $column, '<=', core()->convertToBasePrice(end($temp)))
                                            ->where($aliasTemp . '.attribute_id', $attribute->id);
                                }
                            }
                        });
                    }
                });

                return $qb->groupBy('product_flat.id');
            })->paginate(isset($params['limit']) ? $params['limit'] : 9);

        return $results;
    }

    /**
     * Retrive product from slug
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlugOrFail($slug, $columns = null)
    {
        $product = app('Webkul\Product\Repositories\ProductFlatRepository')->findOneWhere([
                'url_key' => $slug,
                'locale' => app()->getLocale(),
                'channel' => core()->getCurrentChannelCode(),
            ]);

        if (! $product) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->model), $slug
            );
        }

        return $product;
    }

    /**
     * Returns newly added product
     *
     * @return Collection
     */
    public function getNewProducts()
    {
        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                return $query->distinct()
                        ->addSelect('product_flat.*')
                        ->where('product_flat.status', 1)
                        ->where('product_flat.visible_individually', 1)
                        ->where('product_flat.new', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->orderBy('product_id', 'desc');
            })->paginate(4);

        return $results;
    }

    /**
     * Returns featured product
     *
     * @return Collection
     */
    public function getFeaturedProducts()
    {
        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                return $query->distinct()
                        ->addSelect('product_flat.*')
                        ->where('product_flat.status', 1)
                        ->where('product_flat.visible_individually', 1)
                        ->where('product_flat.featured', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->orderBy('product_id', 'desc');
            })->paginate(4);

        return $results;
    }

    /**
     * Search Product by Attribute
     *
     * @return Collection
     */
    public function searchProductByAttribute($term)
    {
        $results = app('Webkul\Product\Repositories\ProductFlatRepository')->scopeQuery(function($query) use($term) {
                $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = request()->get('locale') ?: app()->getLocale();

                return $query->distinct()
                        ->addSelect('product_flat.*')
                        ->where('product_flat.status', 1)
                        ->where('product_flat.visible_individually', 1)
                        ->where('product_flat.channel', $channel)
                        ->where('product_flat.locale', $locale)
                        ->whereNotNull('product_flat.url_key')
                        ->where('product_flat.name', 'like', '%' . urldecode($term) . '%')
                        ->orderBy('product_id', 'desc');
            })->paginate(16);

        return $results;
    }

    /**
     * Returns product's super attribute with options
     *
     * @param Product $product
     * @return Collection
     */
    public function getSuperAttributes($product)
    {
        $superAttrbutes = [];

        foreach ($product->super_attributes as $key => $attribute) {
            $superAttrbutes[$key] = $attribute->toArray();

            foreach ($attribute->options as $option) {
                $superAttrbutes[$key]['options'][] = [
                    'id' => $option->id,
                    'admin_name' => $option->admin_name,
                    'sort_order' => $option->sort_order,
                    'swatch_value' => $option->swatch_value,
                ];
            }
        }

        return $superAttrbutes;
    }
}