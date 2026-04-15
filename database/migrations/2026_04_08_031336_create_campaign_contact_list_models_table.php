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
        Schema::create('campaign_contact_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('contact_list_id');
            $table->timestamps();

            $table->foreign('campaign_id')
                   ->references('id')
                   ->on('campaign')
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
        Schema::dropIfExists('campaign_contact_list');
    }
};
