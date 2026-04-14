<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ cegah duplicate column
        if (!Schema::hasColumn('pipelines', 'project_name')) {

            Schema::table('pipelines', function (Blueprint $table) {
                $table->string('project_name')->nullable();
            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pipelines', 'project_name')) {

            Schema::table('pipelines', function (Blueprint $table) {
                $table->dropColumn('project_name');
            });

        }
    }
};