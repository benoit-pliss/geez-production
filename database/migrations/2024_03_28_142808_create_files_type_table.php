<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Insert some types
        DB::table('files_type')->insert([
            ['name' => 'image', 'id' => 1],
            ['name' => 'video', 'id' => 2],
        ]);

        Schema::table('files', function (Blueprint $table) {
            $table->renameColumn('type', 'id_type');
            $table->string('poster_url')->nullable();
        });

        // Set the type of the existing files
        DB::table('files')->update(['id_type' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files_type');

        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('poster_url');
            $table->renameColumn('id_type', 'type');
        });
    }
};
