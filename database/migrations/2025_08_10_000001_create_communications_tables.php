<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('body_html')->nullable();
            $table->longText('body_text')->nullable();
            $table->enum('selection_mode', ['all', 'custom'])->default('custom');
            $table->timestamp('scheduled_at')->nullable();
            $table->unsignedBigInteger('sent_by');
            $table->string('status')->default('queued');
            $table->json('provider_payload')->nullable();
            $table->timestamps();

            $table->foreign('sent_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('communication_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email');
            $table->string('status')->default('queued');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('error_message')->nullable();
            $table->string('provider_message_id')->nullable();
            $table->timestamps();

            $table->foreign('communication_id')->references('id')->on('communications')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['communication_id', 'status']);
            $table->index(['email']);
        });

        Schema::create('communication_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->string('path');
            $table->string('filename');
            $table->string('mime');
            $table->unsignedBigInteger('size');
            $table->timestamps();

            $table->foreign('communication_id')->references('id')->on('communications')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_attachments');
        Schema::dropIfExists('communication_recipients');
        Schema::dropIfExists('communications');
    }
};


