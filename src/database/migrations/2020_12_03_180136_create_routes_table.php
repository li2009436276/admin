<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->default(0)->comment('父级ID');
            $table->string('name',50)->comment('路由名称');
            $table->string('path')->nullable()->comment('路由地址');
            $table->string('icon',30)->nullable()->comment('图标');
            $table->integer('sort')->default(1)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态：1=显示,2=不显示');
            $table->softDeletes();
            $table->timestamps();

            $table->comment = '路由';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
