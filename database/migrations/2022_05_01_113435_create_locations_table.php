<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_area_id')->comment('店家地址-鄉鎮市區')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('category_id')->comment('店家分類')->index();
            $table->string('name')->comment('店家名稱')->index();
            $table->string('address')->comment('店家地址-其餘地址')->index();
            $table->string('phone')->comment('店家電話')->index();
            $table->float('avgScore')->comment('店家分數')->index();
            $table->longText('introduction')->comment('店家簡介')->nullable();
            $table->longText('images')->comment('圖片路徑')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
