<?php

use App\Traits\MigrationHelpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use MigrationHelpers;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_member_contributions', function (Blueprint $table) {
            $table->id();
            $table->float('contribution_amount')->nullable();
            $table->float('max_loan')->default(0);
            $table->float('take_amount')->nullable()->default(0);
            $table->integer('taken_order')->nullable();
            $table->boolean('taken')->default(false);
            $table->date('taken_date')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('avarist_id')->nullable();
            $table->unsignedBigInteger('session_contribution_id');
            $table->unsignedBigInteger('session_member_id');
            $table->unsignedBigInteger('session_id');
            $this->userForeignColumns($table);
            $this->addDatesColumns($table);
            $table->foreign('session_contribution_id')->references('id')->on('session_contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('session_member_id')->references('id')->on('session_members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('avarist_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_member_contributions');
    }
};
