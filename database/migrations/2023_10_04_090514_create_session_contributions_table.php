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
        Schema::create('session_contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('contribution_id');
            $table->string('loan_period')->nullable();
            $table->date('fund_deadline')->nullable();
            $table->date('loan_duration')->nullable();
            $table->float('loan_interest')->nullable();
            $table->float('fail_interest')->nullable();
            $table->string('fail_interest_type')->nullable();
            $table->unsignedBigInteger('user_id');
            $this->addDatesColumns($table);
            $this->userForeignColumns($table);
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
