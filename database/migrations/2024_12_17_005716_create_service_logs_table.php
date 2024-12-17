<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('admin_id')->constrained('users');
            $table->string('service_type');
            $table->text('description');
            $table->decimal('cost', 12, 2);
            $table->integer('odometer');
            $table->dateTime('service_date');
            $table->dateTime('next_service_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_logs');
    }
};
