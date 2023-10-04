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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone',20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->string('profilePicturePath')->nullable();
            $table->rememberToken();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->string('last_ip')->nullable();
            $table->unsignedBigInteger('association_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->timestamps();
            $table->foreign('association_id')->references('id')->on('associations')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
