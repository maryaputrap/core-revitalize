<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Port;
use App\Models\Tube;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cores', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->foreignIdFor(Port::class, 'port_from_id')->onDeleteCascade();
            $table->foreignIdFor(Port::class, 'port_to_id')->onDeleteCascade();
            $table->foreignIdFor(Tube::class)->onDeleteCascade()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cores');
    }
};
