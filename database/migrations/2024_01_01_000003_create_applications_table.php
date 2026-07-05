<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->text('cover_letter_custom')->nullable();
            $table->timestamps();

            $table->unique(['offer_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};