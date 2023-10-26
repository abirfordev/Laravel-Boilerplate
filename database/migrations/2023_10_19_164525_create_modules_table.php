<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('url')->nullable();
            $table->string('permission_slug')->unique();
            $table->tinyInteger('is_label')->nullable();
            $table->tinyInteger('is_children')->nullable();
            $table->unsignedBigInteger('parent_module_id')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
