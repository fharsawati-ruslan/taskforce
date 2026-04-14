<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ cek dulu biar tidak duplicate
        if (!Schema::hasColumn('companies', 'website')) {

            Schema::table('companies', function (Blueprint $table) {
                $table->string('website')->nullable();
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('companies', 'website')) {

            Schema::table('companies', function (Blueprint $table) {
                $table->dropColumn('website');
            });

        }
    }
};