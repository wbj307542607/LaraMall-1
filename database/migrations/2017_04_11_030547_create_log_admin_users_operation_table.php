<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogAdminUsersOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_admin_users_operation', function (Blueprint $table) {
            $table->increments('id')->comment('管理员操作日志表');
            $table->integer('operator_id')->index()->comment('管理员ID');
            $table->ipAddress('login_ip')->comment('登录IP');
            $table->string('events')->comment('操作事件 (路由与参数)');
            $table->text('content')->comment('操作内容');
            $table->timestamps();
            $table->softDeletes()->comment('软删除');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_admin_users_operation');
    }
}