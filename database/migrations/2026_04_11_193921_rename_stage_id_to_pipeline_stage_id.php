<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('pipelines', 'stage_id')) {
            Schema::table('pipelines', function (Blueprint $table) {
                $table->renameColumn('stage_id', 'pipeline_stage_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pipelines', 'pipeline_stage_id')) {
            Schema::table('pipelines', function (Blueprint $table) {
                $table->renameColumn('pipeline_stage_id', 'stage_id');
            });
        }
    }
};