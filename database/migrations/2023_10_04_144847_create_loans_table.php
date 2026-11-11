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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->text('reason');
            $table->text('type'); // Retournable or not
            $table->float('interest');
            $table->string('interest_type'); // type d'interet pourcentage ou autre
            $table->float('interest_amount');
            $table->float('total_amount');
            $table->string('status')->default(false);
            $table->date('return_date')->nullable();
            $table->date('real_return_date')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contribution_id')->nullable();
            $table->unsignedBigInteger('create_id')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $this->addDatesColumns($table);
            $this->statusForeignColumns($table);
            $this->userForeignColumns($table);
            $table->foreign('contribution_id')->references('id')->on('contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('create_id')->references('id')->on('creates')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')
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
