<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->string('cv_path');
            $table->timestamps();

            // Sesuai kebutuhan: Freelancer hanya bisa submit 1 CV untuk 1 postingan
            $table->unique(['job_posting_id', 'freelancer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
};
