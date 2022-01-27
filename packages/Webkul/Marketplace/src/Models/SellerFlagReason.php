<?php

namespace Webkul\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Marketplace\Contracts\SellerFlagReason as SellerFlagReasonContract;

class SellerFlagReason extends Model implements SellerFlagReasonContract
{
    protected $table = 'marketplace_seller_flag_reasons';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}