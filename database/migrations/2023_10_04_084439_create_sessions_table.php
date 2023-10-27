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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type',50);
            $table->string('frequency',50);
            $table->string('meeting_day',50);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('contribution_id');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
//            $table->foreign('contribution_id')->references('id')->on('contributions')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
