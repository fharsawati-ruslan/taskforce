<?php

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
        Schema::create('booking_rooms', function (Blueprint $table) {
		$table->id();

	$table->string('room');
        $table->string('activity');

        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');

        $table->string('company_name')->nullable();
        $table->integer('guest_count')->default(0);

        $table->integer('aqua')->default(0);
        $table->integer('coffee')->default(0);
        $table->integer('tea')->default(0);

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_rooms');
    }
};
