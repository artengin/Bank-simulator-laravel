<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use RonasIT\Support\Traits\MigrationTrait;

return new class extends Migration
{
    use MigrationTrait;

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('initializer_id')->nullable();
            $table
                ->foreign('initializer_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->string('name');
            $table->bigInteger('card_number');
            $table->integer('amount');
            $table->enum('type', ['incoming', 'outgoing']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
