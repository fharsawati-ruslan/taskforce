<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ hanya jalan kalau column belum ada
        if (!Schema::hasColumn('companies', 'industry_id')) {

            Schema::table('companies', function (Blueprint $table) {

                if (Schema::hasTable('industries')) {
                    $table->foreignId('industry_id')
                        ->nullable()
                        ->constrained('industries')
                        ->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('industry_id')->nullable();
                }

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('companies', 'industry_id')) {

            Schema::table('companies', function (Blueprint $table) {

                try {
                    $table->dropForeign(['industry_id']);
                } catch (\Throwable $e) {
                    // ignore
                }

                $table->dropColumn('industry_id');

            });

        }
    }
};