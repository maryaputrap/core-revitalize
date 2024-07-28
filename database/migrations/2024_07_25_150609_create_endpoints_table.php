<?php

use App\Models\Container;
use App\Models\OptionReference;
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
        Schema::create('endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OptionReference::class, 'type_id')->nullable()->onDeleteNull();
            $table->foreignIdFor(Container::class)->nullable()->onDeleteNull();
            $table->string('code');
            $table->string('name');
            $table->unsignedMediumInteger('port_total')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endpoints');
    }
};
