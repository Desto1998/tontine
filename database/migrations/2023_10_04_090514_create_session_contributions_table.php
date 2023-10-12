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
        Schema::create('session_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('contribution_id');
            $table->timestamps();
            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('contribution_id')->references('id')->on('contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_contributions');
    }
};
