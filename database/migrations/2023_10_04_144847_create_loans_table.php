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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->text('reason');
            $table->text('type'); // Retournable or not
            $table->float('interest');
            $table->string('interest_type'); // type d'interet pourcentage ou autre
            $table->float('total_amount');
            $table->boolean('status')->default(false);
            $table->date('return_date')->nullable();
            $table->date('real_return_date')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contribution_id')->nullable();
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('meeting_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('contribution_id')->references('id')->on('contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('create_id')->references('id')->on('creates')
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
        Schema::dropIfExists('loans');
    }
};
