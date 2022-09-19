<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->comment('發文者')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->comment('店家')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->comment('文章標題')->index();
            $table->longText('content')->comment('文章內容')->nullable();
            $table->timestamp('published_at')->comment('發佈時間')->nullable()->index();
            $table->boolean('active')->comment('啟用狀態')->default(true)->index();
            $table->string('slug')->comment('自訂網址')->index();
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
        Schema::dropIfExists('posts');
    }
}
