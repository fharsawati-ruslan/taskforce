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
        Schema::create('pipelines', function (Blueprint $table) {
            $table->id();

            // 🔗 RELASI (explicit table biar aman)
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('pipeline_stage_id')
                ->constrained('pipeline_stages')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // 📌 DATA PROJECT
            $table->string('project_name');

            // 👤 SNAPSHOT CONTACT
            $table->string('pic_name')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('email')->nullable();

            // 💰 NILAI PROJECT
            $table->decimal('value', 15, 2)->nullable();

            // 📊 STATUS
            $table->enum('status', ['open', 'progress', 'won', 'lost'])
                ->default('open');

            $table->unsignedInteger('progress')->default(0); // lebih aman dari integer biasa

            // 📅 ACTIVITY
            $table->dateTime('meeting_date')->nullable();
            $table->date('next_follow_up')->nullable();
            $table->date('closing_date')->nullable();

            $table->string('meeting_type')->nullable(); // onsite / online

            // 📝 NOTES
            $table->text('notes')->nullable();

            // ⚡ INDEX (optional tapi recommended)
            $table->index('status');
            $table->index('pipeline_stage_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipelines');
    }
};