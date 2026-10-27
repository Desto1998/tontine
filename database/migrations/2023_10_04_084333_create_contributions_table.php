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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->float('amount')->default(0);
            $table->string('loan_period')->nullable();
            $table->date('fund_deadline')->nullable();
            $table->date('loan_duration')->nullable();
            $table->float('loan_interest')->nullable();
            $table->float('fail_interest')->nullable();
            $table->string('fail_interest_type')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('status_id')->default(1);
            $this->addDatesColumns($table);
            $this->statusForeignColumns($table);
            $this->userForeignColumns($table);
            $this->associationForeignColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
