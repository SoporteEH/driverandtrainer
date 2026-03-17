<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('event_artist');
            $table->string('location');
            $table->string('van');
            $table->date('date');
            $table->time('entry_time');
            $table->time('exit_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_jobs');
    }
};
