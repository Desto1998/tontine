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
        Schema::create('meeting_session_members', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->float('take_amount')->nullable()->default(0);
            $table->string('present');
            $table->boolean('took')->default(false);
            $table->unsignedBigInteger('avarist')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('session_contribution_id');
            $table->unsignedBigInteger('session_member_id');
            $table->unsignedBigInteger('meeting_id');
            $this->addDatesColumns($table);
            $this->userForeignColumns($table);
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
