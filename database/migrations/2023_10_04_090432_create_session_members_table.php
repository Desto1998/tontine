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
        Schema::create('session_members', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->nullable();
            $table->integer('take_order')->default(0);
            $table->boolean('taken')->default(false);
            $table->date('taken_date')->nullable();
            $table->float('taken_amount')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('member_id');
            $this->addDatesColumns($table);
            $this->userForeignColumns($table);
            $table->foreign('session_id')->references('id')->on('sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_members');
    }
};
