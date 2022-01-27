<?php

namespace Webkul\Marketplace\Listeners;

use Illuminate\Support\Facades\Mail;
use Webkul\Marketplace\Repositories\OrderRepository;
use Webkul\Marketplace\Mail\NewOrderNotification;
use Webkul\Marketplace\Mail\NewInvoiceNotification;
use Webkul\Marketplace\Mail\NewShipmentNotification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Marketplace\Repositories\ProductRepository as MpProductRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;

/**
 * Product event handler
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Product
{
    /**
     * OrderRepository object
     *
     * @var Product
    */
    protected $order;

     /**
     * AttributeRepository Repository Object
     *
     * @var object
     */
    protected $attributeRepository;

    /**
     * AttributeOptionRepository Repository Object
     *
     * @var object
     */
    protected $attributeOptionRepository;

    /**
     * ProductFlatRepository Repository Object
     *
     * @var object
     */
    protected $productFlatRepository;

    /**
     * Attribute Object
     *
     * @var object
     */
    protected $attribute;

    /**
     * mpProductRepository Object
     *
     * @var object
     */
    protected $mpProductRepository;

    /**
     * ProductInventoryRepository object
     *
     * @var array
     */
    protected $productInventoryRepository;

    /**
     * @var object
     */
    public $attributeTypeFields = [
        'text' => 'text',
        'textarea' => 'text',
        'price' => 'float',
        'boolean' => 'boolean',
        'select' => 'integer',
        'multiselect' => 'text',
        'datetime' => 'datetime',
        'date' => 'date',
        'file' => 'text',
        'image' => 'text',
        'checkbox' => 'text'
    ];

    /**
     * Create a new listener instance.
     *
     * @param  Webkul\Attribute\Repositories\AttributeRepository           $attributeRepository
     * @param  Webkul\Attribute\Repositories\AttributeOptionRepository     $attributeOptionRepository
     * @param  Webkul\Product\Repositories\ProductFlatRepository           $productFlatRepository
     * @return void
     */

    /**
     * Create a new customer event listener instance.
     *
     * @param  Webkul\Marketplace\Repositories\OrderRepository $order
     * @param  Webkul\Product\Repositories\ProductInventoryRepository $productInventoryRepository
     * @return void
     */
    public function __construct(
        OrderRepository $order,
        AttributeRepository $attributeRepository,
        AttributeOptionRepository $attributeOptionRepository,
        ProductFlatRepository $productFlatRepository,
        MpProductRepository $mpProductRepository,
        ProductInventoryRepository $productInventoryRepository
    )
    {
        $this->order = $order;

        $this->attributeRepository = $attributeRepository;

        $this->attributeOptionRepository = $attributeOptionRepository;

        $this->productFlatRepository = $productFlatRepository;

        $this->mpProductRepository = $mpProductRepository;

        $this->productInventoryRepository = $productInventoryRepository;
    }


    public function BeforeProductCreate($id) {

        $data = request()->all();

        if (! isset($data['variants'])) {
            $sellerProduct = $this->mpProductRepository->findOneWhere([
                'product_id' => $id,
                'is_owner' => 1
            ]);

            if (isset($sellerProduct)) {

                $this->productInventoryRepository->saveInventories(array_merge($data, [
                    'vendor_id' => $sellerProduct->marketplace_seller_id
                ]), $sellerProduct->product);
            }
        } else if(isset($data['variants'])) {

            foreach($data['variants'] as $productId => $variant) {

                $sellerProduct = $this->mpProductRepository->findOneWhere([
                    'product_id' => $productId,
                    'is_owner' => 1
                ]);

                if (isset($sellerProduct)) {

                    $this->productInventoryRepository->saveInventories(array_merge($variant, [
                        'vendor_id' => $sellerProduct->marketplace_seller_id
                    ]), $sellerProduct->product);
                }
            }
        }

    }
        /**
     * After the attribute is created
     *
     * @return void
     */
    public function afterAttributeCreatedUpdated($attribute)
    {
        if (! $attribute->is_user_defined) {
            return false;
        }

        if (! $attribute->use_in_flat) {
            $this->afterAttributeDeleted($attribute->id);
            return false;
        }

        if (! Schema::hasColumn('product_flat', $attribute->code)) {
            Schema::table('product_flat', function (Blueprint $table) use($attribute) {
                $table->{$this->attributeTypeFields[$attribute->type]}($attribute->code)->nullable();

                if ($attribute->type == 'select' || $attribute->type == 'multiselect') {
                    $table->string($attribute->code . '_label')->nullable();
                }
            });
        }
    }

    public function afterAttributeDeleted($attributeId)
    {
        $attribute = $this->attributeRepository->find($attributeId);

        if (Schema::hasColumn('product_flat', strtolower($attribute->code))) {
            Schema::table('product_flat', function (Blueprint $table) use($attribute) {
                $table->dropColumn($attribute->code);

                if ($attribute->type == 'select' || $attribute->type == 'multiselect') {
                    $table->dropColumn($attribute->code . '_label');
                }
            });
        }
    }

    /**
     * Creates product flat
     *
     * @param Product $product
     * @return void
     */
    public function afterProductCreatedUpdated($product)
    {
        $this->createFlat($product);

        if ($product->type == 'configurable') {
            foreach ($product->variants()->get() as $variant) {
                $this->createFlat($variant, $product);
            }
        }
    }

    /**
     * Creates product flat
     *
     * @param Product $product
     * @param Product $parentProduct
     * @return void
     */
    public function createFlat($product, $parentProduct = null)
    {
        static $familyAttributes = [];

        static $superAttributes = [];

        if (! array_key_exists($product->attribute_family->id, $familyAttributes))
            $familyAttributes[$product->attribute_family->id] = $product->attribute_family->custom_attributes;

        if ($parentProduct && ! array_key_exists($parentProduct->id, $superAttributes))
            $superAttributes[$parentProduct->id] = $parentProduct->super_attributes()->pluck('code')->toArray();

        if (isset($product['channels'])) {
            foreach ($product['channels'] as $channel) {
                $channel = app('Webkul\Core\Repositories\ChannelRepository')->findOrFail($channel);
                $channels[] = $channel['code'];
            }
        } else if (isset($parentProduct['channels'])){
            foreach ($parentProduct['channels'] as $channel) {
                $channel = app('Webkul\Core\Repositories\ChannelRepository')->findOrFail($channel);
                $channels[] = $channel['code'];
            }
        } else {
            $channels[] = core()->getDefaultChannelCode();
        }

        if (request()->has('customer_group_prices')) {
            app('Webkul\Product\Repositories\ProductCustomerGroupPriceRepository')->saveCustomerGroupPrices(request()->all(),
            $product);
        }

        foreach (core()->getAllChannels() as $channel) {
            if (in_array($channel->code, $channels)) {
                foreach ($channel->locales as $locale) {
                    $productFlat = $this->productFlatRepository->findOneWhere([
                        'product_id' => $product->id,
                        'channel' => $channel->code,
                        'locale' => $locale->code
                    ]);

                    if (! $productFlat) {
                        $productFlat = $this->productFlatRepository->create([
                            'product_id' => $product->id,
                            'channel' => $channel->code,
                            'locale' => $locale->code
                        ]);
                    }

                    foreach ($familyAttributes[$product->attribute_family->id] as $attribute) {
                        if ($parentProduct && ! in_array($attribute->code, array_merge($superAttributes[$parentProduct->id], ['sku', 'name', 'price', 'weight', 'status'])))
                            continue;

                        if (in_array($attribute->code, ['tax_category_id']))
                            continue;

                        if (! Schema::hasColumn('product_flat', $attribute->code))
                            continue;

                        if ($attribute->value_per_channel) {
                            if ($attribute->value_per_locale) {
                                $productAttributeValue = $product->attribute_values()->where('channel', $channel->code)->where('locale', $locale->code)->where('attribute_id', $attribute->id)->first();
                            } else {
                                $productAttributeValue = $product->attribute_values()->where('channel', $channel->code)->where('attribute_id', $attribute->id)->first();
                            }
                        } else {
                            if ($attribute->value_per_locale) {
                                $productAttributeValue = $product->attribute_values()->where('locale', $locale->code)->where('attribute_id', $attribute->id)->first();
                            } else {
                                $productAttributeValue = $product->attribute_values()->where('attribute_id', $attribute->id)->first();
                            }
                        }

                        if ($product->type == 'configurable' && $attribute->code == 'price') {
                            try {
                                $productFlat->{$attribute->code} = app('Webkul\Marketplace\Helpers\Price')->getVariantMinPrice($product);
                            } catch (\Exception $e) {}
                        } else {
                            try {
                                $productFlat->{$attribute->code} = $productAttributeValue[ProductAttributeValue::$attributeTypeFields[$attribute->type]];
                            } catch (\Exception $e) {}
                        }

                        if ($attribute->type == 'select') {
                            $attributeOption = $this->attributeOptionRepository->find($product->{$attribute->code});
                            if ($attributeOption) {
                                if ($attributeOptionTranslation = $attributeOption->translate($locale->code)) {
                                    $productFlat->{$attribute->code . '_label'} = $attributeOptionTranslation->label;
                                } else {
                                    $productFlat->{$attribute->code . '_label'} = $attributeOption->admin_name;
                                }
                            }
                        } elseif ($attribute->type == 'multiselect') {
                            $attributeOptionIds = explode(',', $product->{$attribute->code});

                            if (count($attributeOptionIds)) {
                                $attributeOptions = $this->attributeOptionRepository->findWhereIn('id', $attributeOptionIds);

                                $optionLabels = [];

                                foreach ($attributeOptions as $attributeOption) {
                                    if ($attributeOptionTranslation = $attributeOption->translate($locale->code)) {
                                        $optionLabels[] = $attributeOptionTranslation->label;
                                    } else {
                                        $optionLabels[] = $attributeOption->admin_name;
                                    }
                                }

                                $productFlat->{$attribute->code . '_label'} = implode(', ', $optionLabels);
                            }
                        }
                    }
                    $productFlat->created_at = $product->created_at;

                    $productFlat->updated_at = $product->updated_at;

                    if ($parentProduct) {
                        $parentProductFlat = $this->productFlatRepository->findOneWhere([
                                'product_id' => $parentProduct->id,
                                'channel' => $channel->code,
                                'locale' => $locale->code
                            ]);

                        if ($parentProductFlat) {
                            $productFlat->parent_id = $parentProductFlat->id;
                        }
                    }

                    $productFlat->save();
                }
            } else {
                $route = request()->route() ? request()->route()->getName() : "";

                if ($route == 'admin.catalog.products.update') {
                    $productFlat = $this->productFlatRepository->findOneWhere([
                        'product_id' => $product->id,
                        'channel' => $channel->code,
                    ]);

                    if ($productFlat) {
                        $this->productFlatRepository->delete($productFlat->id);
                    }
                }
            }
        }
    }


}