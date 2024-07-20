<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Container;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hardwares', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->unsignedMediumInteger('port_total')->default(0);
            $table->foreignIdFor(Container::class)->onDeleteNull();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardwares');
    }
};
