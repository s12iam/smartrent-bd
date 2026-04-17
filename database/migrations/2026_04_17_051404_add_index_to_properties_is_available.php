<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;  #used to define the structure of the database tables.    
use Illuminate\Support\Facades\Schema;  #used to create, modify, or delete tables.

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void #apply change 
    {
        Schema::table('properties_is_available', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void   #undo  change
    {
        Schema::table('properties_is_available', function (Blueprint $table) {
            //
        });
    }
};
