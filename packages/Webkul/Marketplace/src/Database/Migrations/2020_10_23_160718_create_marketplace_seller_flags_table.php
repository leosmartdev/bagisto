<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplaceSellerFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplace_seller_flags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('reason');
            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_flags');
    }
}
