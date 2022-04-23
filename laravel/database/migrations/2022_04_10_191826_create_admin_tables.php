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
            $table->string('name', 30)->comment('姓名/昵称');
            $table->string('avatar', 255)->comment('头像');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_users` comment '管理员表'");

        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->comment('菜单名');
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
            $table->string('name', 60)->comment('路由标题');
            $table->string('route', 128)->nullable()->comment('路由名称，保持跟路由规则处的name相同');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_routes` comment '路由表'");

        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->comment('角色名');
            $table->string('slug', 60)->comment('标识符');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_roles` comment '管理员角色表'");

        Schema::create('admin_role_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_role_id')->default(0)->comment('角色ID');
            $table->unsignedInteger('admin_route_id')->default(0)->comment('路由ID');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_role_routes` comment '管理员角色权限表'");

        Schema::create('admin_role_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_role_id')->default(0)->comment('角色ID');
            $table->unsignedInteger('admin_user_id')->default(0)->comment('用户ID');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_role_users` comment '管理员角色用户表'");

        Schema::create('admin_role_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_role_id')->default(0)->comment('角色ID');
            $table->unsignedInteger('admin_menu_id')->default(0)->comment('菜单ID');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_role_menus` comment '管理员角色菜单表'");

        Schema::create('admin_operation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('admin_user_id')->default(0)->comment('管理员ID');
            $table->string('route', 255)->comment('路由');
            $table->string('method', 10)->comment('请求方式');
            $table->string('ip', 60)->comment('请求IP');
            $table->text('input')->comment('请求参数');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `admin_operation_logs` comment '管理员操作日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
        Schema::dropIfExists('admin_menus');
        Schema::dropIfExists('admin_routes');
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('admin_role_routes');
        Schema::dropIfExists('admin_role_users');
        Schema::dropIfExists('admin_role_menus');
        Schema::dropIfExists('admin_operation_logs');
    }
}
