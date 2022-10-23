<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationServiceHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_service_hours', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('location_id')->comment('店家')->constrained()->cascadeOnDelete();
            $table->timestamp('opened_at')->comment('開始時間')->nullable()->index();
            $table->timestamp('closed_at')->comment('結束時間')->nullable()->index();
            $table->smallInteger('weekday')->comment('工作日')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_service_hours');
    }
}
