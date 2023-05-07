<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->comment('角色ID');
            $table->string('account',20)->comment('账号');
            $table->string('pwd')->comment('密码');
            $table->string('salt',5)->comment('密码池');
            $table->string('nickname',50)->comment('昵称');
            $table->string('phone',11)->comment('手机号');
            $table->string('email',20)->comment('邮箱');
            $table->string('head_img')->nullable()->comment('头像');
            $table->tinyInteger('status')->default(1)->comment('状态：1=正常,2=禁用,3=离职');
            $table->softDeletes();
            $table->timestamps();

            $table->comment = '管理员';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
