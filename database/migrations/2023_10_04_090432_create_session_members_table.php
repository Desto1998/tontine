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
        Schema::create('session_members', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->integer('take_order')->default(0);
            $table->boolean('taken')->default(false);
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('member_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_members');
    }
};
