<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\ProductFlag as ProductFlagContract;

class ProductFlag extends Model implements ProductFlagContract
{
    protected $table = 'marketplace_product_flags';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
