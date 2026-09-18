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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->float('amount');
            $table->float('interest');
            $table->string('interest_type');
            $table->float('interest_amount');
            $table->float('total_amount');
            $table->string('status');
            $table->date('nm_time')->nullable();
            $table->date('refund_date');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contribution_id')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('investments');
    }
};
