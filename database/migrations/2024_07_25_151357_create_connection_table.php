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
            $table->char('tube')->nullable();
            $table->string('tube_color')->nullable();
            $table->string('cable')->nullable();
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
