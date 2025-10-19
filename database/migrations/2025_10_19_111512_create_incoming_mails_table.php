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
        Schema::create('incoming_mails', function (Blueprint $table) {
            $table->id();
            $table->integer('mail_type_id');
            $table->integer('classification_id');
            $table->string('mail_number', 150)->unique();
            $table->date('mail_date');
            $table->date('received_date');
            $table->string('origin');
            $table->string('destination');
            $table->string('subject');
            $table->string('file_path')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_mails');
    }
};
