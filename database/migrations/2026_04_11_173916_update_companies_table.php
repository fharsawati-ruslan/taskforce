<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ pastikan tabel companies ada
        if (Schema::hasTable('companies')) {

            Schema::table('companies', function (Blueprint $table) {

                // ✅ industry_id (relasi ke industries)
                if (!Schema::hasColumn('companies', 'industry_id')) {

                    // cek tabel industries dulu
                    if (Schema::hasTable('industries')) {
                        $table->foreignId('industry_id')
                            ->nullable()
                            ->constrained('industries')
                            ->nullOnDelete();
                    } else {
                        // fallback kalau industries belum ada
                        $table->unsignedBigInteger('industry_id')->nullable();
                    }
                }

                // ✅ website
                if (!Schema::hasColumn('companies', 'website')) {
                    $table->string('website')->nullable();
                }

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasTable('companies')) {

            Schema::table('companies', function (Blueprint $table) {

                // drop FK dulu baru column
                if (Schema::hasColumn('companies', 'industry_id')) {
                    try {
                        $table->dropForeign(['industry_id']);
                    } catch (\Throwable $e) {
                        // ignore kalau FK belum ada
                    }

                    $table->dropColumn('industry_id');
                }

                if (Schema::hasColumn('companies', 'website')) {
                    $table->dropColumn('website');
                }

            });

        }
    }
};