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
        if (!Schema::hasColumn('users', 'encryption_enabled')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('encryption_enabled')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'encryption_enabled')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('encryption_enabled');
            });
        }
    }
};
