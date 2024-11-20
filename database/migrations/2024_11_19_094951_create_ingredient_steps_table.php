<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredient_step', function (Blueprint $table) {
            $table->foreignId('step_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->float('amount');
            $table->string('unit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredient_steps');
    }
};
