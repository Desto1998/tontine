<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\MigrationHelpers;

return new class extends Migration
{
    use MigrationHelpers;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('old_status_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contribution_id')->nullable();
            $table->unsignedBigInteger('investment_id')->nullable();
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->unsignedBigInteger('refund_id')->nullable();
            $this->addDatesColumns($table);
            $this->statusForeignColumns($table);
            $this->userForeignColumns($table);

            $table->foreign('old_status_id')->references('id')->on('statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('contribution_id')->references('id')->on('contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('investment_id')->references('id')->on('investments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('loan_id')->references('id')->on('loans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('refund_id')->references('id')->on('refunds')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histories');
    }
};
