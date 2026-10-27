<?php

// app/Traits/MigrationHelpers.php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait MigrationHelpers
{
    protected static function addDatesColumns(Blueprint $table): void
    {
        $table->unsignedBigInteger('deleted_by')->nullable();
        $table->softDeletes();
        $table->timestamps();
        $table->foreign('deleted_by')->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    }

    protected static function foreignKeysColumns(Blueprint $table): void
    {

    }

    protected static function statusForeignColumns(Blueprint $table): void
    {
        $table->foreign('status_id')->references('id')->on('statuses')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    }

    protected static function userForeignColumns(Blueprint $table): void
    {
        $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade')
        ;
    }
    protected static function associationForeignColumns(Blueprint $table): void
    {
        $table->foreign('association_id')->references('id')->on('associations')
            ->onUpdate('cascade')
            ->onDelete('cascade')
        ;

    }
}
