<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ cek dulu biar tidak duplicate
        if (!Schema::hasColumn('solutions', 'brand')) {
            Schema::table('solutions', function (Blueprint $table) {
                $table->string('brand')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('solutions', 'brand')) {
            Schema::table('solutions', function (Blueprint $table) {
                $table->dropColumn('brand');
            });
        }
    }
};