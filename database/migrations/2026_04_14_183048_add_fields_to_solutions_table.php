<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solutions', function (Blueprint $table) {

            if (!Schema::hasColumn('solutions', 'brand')) {
                $table->string('brand')->nullable();
            }

            if (!Schema::hasColumn('solutions', 'price')) {
                $table->bigInteger('price')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->dropColumn(['brand', 'price']);
        });
    }
};