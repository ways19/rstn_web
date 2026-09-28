<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_modules', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('group')->default('Umum');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('route_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('location')->default('public'); // 'public' or 'admin'
            $table->foreignId('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('icon')->nullable();
            $table->string('target')->default('_self'); // '_self' or '_blank'
            $table->string('permission_name')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
        Schema::dropIfExists('app_modules');
    }
};
