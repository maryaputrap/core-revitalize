<?php

use App\Models\Endpoint;
use App\Models\Hardware;
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
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Endpoint::class)->onDeleteNull();
            $table->string('name');
            $table->boolean('is_connected')->default(false);
            $table->unsignedSmallInteger('splitter')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
