<?php

use App\Models\Port;
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
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Port::class, 'from_port_id')->cascadeOnDelete();
            $table->foreignIdFor(Port::class, 'to_port_id')->cascadeOnDelete();
            $table->char('tube')->nullable(); // example: A, B, C, D, E,...
            $table->string('tube_color')->nullable(); // example: red, blue, green, yellow,...
            $table->string('cable')->nullable(); // example: MGB 24C/8T/6C
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection');
    }
};
