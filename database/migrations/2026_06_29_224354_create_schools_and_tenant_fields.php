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
        // 1. Create schools table
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('logo')->nullable();
            $table->string('primary_color')->default('#1e3a8a');
            $table->string('secondary_color')->default('#3b82f6');
            $table->text('welcome_headmaster')->nullable();
            $table->text('welcome_alumni')->nullable();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('google_maps')->nullable();
            $table->timestamps();
        });

        // 2. Add school_id column to other tables
        $tables = [
            'users',
            'posts',
            'events',
            'donations',
            'careers',
            'businesses',
            'forum_topics',
            'galleries'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // school_id is nullable so it doesn't break existing seeds/structures immediately
                $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'posts',
            'events',
            'donations',
            'careers',
            'businesses',
            'forum_topics',
            'galleries'
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('school_id');
            });
        }

        Schema::dropIfExists('schools');
    }
};
