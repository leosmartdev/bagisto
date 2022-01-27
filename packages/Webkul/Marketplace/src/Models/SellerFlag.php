<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\SellerFlag as SellerFlagContract;

class SellerFlag extends Model implements SellerFlagContract
{
    protected $table = 'marketplace_seller_flags';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
