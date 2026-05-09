<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropUnique('images_name_unique');
            $table->unique(['name', 'id_type']);
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropUnique(['name', 'id_type']);
            $table->unique('name', 'images_name_unique');
        });
    }
};
