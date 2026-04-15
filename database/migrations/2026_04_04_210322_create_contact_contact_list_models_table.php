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
        Schema::create('contact_contact_list', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('contact_list_id');

            // Foreign keys with cascade delete
            $table->foreign('contact_id')
                  ->references('id')
                  ->on('contact')
                  ->onDelete('cascade');

            $table->foreign('contact_list_id')
                  ->references('id')
                  ->on('contact_list')
                  ->onDelete('cascade');
                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_contact_list');
    }
};