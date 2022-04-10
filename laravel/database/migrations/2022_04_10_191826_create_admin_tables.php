<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->comment('用户名')->index();
            $table->string('password', 64)->comment('密码');
            $table->string('name', 30)->comment('姓名');
            $table->string('avatar', 255)->comment('头像');
            $table->string('mobile', 20)->nullable()->comment('手机号')->index();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_users` comment '管理员表'");

        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60)->comment('菜单名');
            $table->string('path', 128)->nullable()->comment('路径');
            $table->unsignedInteger('parent_id')->default(0)->comment('父级菜单ID');
            $table->unsignedInteger('order')->default(0)->comment('顺序');
            $table->string('icon', 30)->comment('图标');
            $table->unsignedTinyInteger('disabled')->default(0)->comment('禁用');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_menus` comment '菜单表'");

        Schema::create('admin_routes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60)->comment('路由名');
            $table->string('path', 128)->nullable()->comment('路径');
            $table->unsignedInteger('parent_id')->default(0)->comment('父级菜单ID');
            $table->unsignedInteger('order')->default(0)->comment('顺序');
            $table->string('icon', 30)->comment('图标');
            $table->unsignedTinyInteger('disabled')->default(0)->comment('禁用');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_routes` comment '路由表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
