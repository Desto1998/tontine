<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use App\Traits\MigrationHelpers;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crates', function (Blueprint $table) {
            $table->id();
            $table->string('reason')->nullable();
            $table->string('categorie')->nullable();//(Cotisation, Remboursement de prêt, Décaissement de prêt, Paiement d'amende/sanction, Frais divers, Retrait d'investissement)
            $table->float('amount')->default(0);
            $table->date('date');
            $table->enum('operation_type',['Sortie', 'Entrée'])->default('Entrée');
            $table->text('comment')->nullable();
            $table->text('referencePiece')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sanction_id')->nullable();
            $table->unsignedBigInteger('session_contribution_id')->nullable();
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('fund_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $this->userForeignColumns($table);
            $this->addDatesColumns($table);
            $table->foreign('session_contribution_id')->references('id')->on('session_contributions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('meeting_id')->references('id')->on('meetings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('sanction_id')->references('id')->on('sanctions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('fund_id')->references('id')->on('funds')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('association_id')->references('id')->on('associations')
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
        Schema::dropIfExists('crates');
    }
};
