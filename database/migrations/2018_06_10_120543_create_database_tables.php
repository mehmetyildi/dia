<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       

        /* Article.php */
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('caption_tr')->nullable();
            $table->text('caption_en')->nullable();
            $table->text('description_tr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('url_tr');
            $table->string('url_en');
            $table->string('video_path')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('promote')->default(false);
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->date('actual_date')->nullable();
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        /* ArticleImage.php */
        Schema::create('article_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('caption_tr')->nullable();
            $table->text('caption_en')->nullable();
            $table->string('link');                        
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->boolean('new_tab')->default(false);
            $table->integer('position')->default(1);
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('popups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image_path_tr')->nullable();
            $table->string('image_path_en')->nullable();
            $table->string('video_path')->nullable();
            $table->string('link')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('publish')->default(false);
            $table->integer('position')->default(1);
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->string('title_tr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('publish')->default(false);
            $table->boolean('new_tab')->default(false);
            $table->integer('position')->default(1);
            $table->date('publish_at')->nullable();
            $table->date('publish_until')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_images');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('popups');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('product_images');
        

       
    }
}
