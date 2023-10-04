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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone',20);
            $table->string('address');
            $table->string('city', 80);
            $table->boolean('has_fund')->default(true);
            $table->float('fund_amount')->default(0);
            $table->unsignedBigInteger('association_id');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('association_id')->references('id')->on('associations')
                ->onUpdate('cascade')
                ->onDelete('cascade')
            ;
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
