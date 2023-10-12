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
        Schema::create('meeting_session_members', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('present');
            $table->boolean('took')->default(false);
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('session_contribution_id');
            $table->unsignedBigInteger('session_member_id');
            $table->unsignedBigInteger('meeting_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('session_contribution_id')->references('id')->on('session_contributions')
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
        Schema::dropIfExists('meeting_session_members');
    }
};
