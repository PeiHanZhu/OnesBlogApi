<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('city_id')->comment('縣市')->constrained()->cascadeOnDelete();
            $table->string('city_area')->comment('鄉鎮市區')->index();
            $table->string('zip_code')->comment('郵遞區號')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_areas');
    }
}
