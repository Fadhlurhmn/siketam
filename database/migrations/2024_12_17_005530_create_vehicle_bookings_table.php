<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('supervisor_id')->constrained('users');
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('purpose');
            $table->enum('status', ['pending', 'approved_supervisor', 'approved_admin', 'rejected', 'completed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_bookings');
    }
};
