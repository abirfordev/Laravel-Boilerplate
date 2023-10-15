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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('type')->nullable()->default('Alumni');
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('dob')->nullable();
            $table->longText('address')->nullable();
            $table->tinyInteger('is_registered')->nullable();
            $table->unsignedBigInteger('current_membership_id')->nullable();
            $table->unsignedBigInteger('committee_id')->nullable()->comment("Running committee id when an alumni is going to be registered");
            $table->string('validity_date')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
