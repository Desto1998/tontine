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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
            $table->foreign('association_id')->references('id')->on('associations')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('meeting_id')->references('id')->on('meetings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
