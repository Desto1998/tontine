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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone',20);
            $table->string('address');
            $table->boolean('status')->default(1);
            $table->string('city', 80);
            $table->boolean('has_fund')->default(true);
            $table->float('fund_amount')->default(0);
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
        Schema::dropIfExists('members');
    }
};
