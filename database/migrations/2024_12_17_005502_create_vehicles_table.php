<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->enum('type', ['passenger', 'cargo']);
            $table->string('brand');
            $table->string('model');
            $table->enum('ownership_type', ['owned', 'rental']);
            $table->integer('capacity');
            $table->enum('status', ['available', 'in_use', 'maintenance', 'inactive']);
            $table->foreignId('region_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
