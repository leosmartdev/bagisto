<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\ProductFlagReason as ProductFlagReasonContract;

class ProductFlagReason extends Model implements ProductFlagReasonContract
{
    protected $table = 'marketplace_product_flag_reasons';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}