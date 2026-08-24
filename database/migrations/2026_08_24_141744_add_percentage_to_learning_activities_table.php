<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learning_activities', function (Blueprint $table) {
            $table->integer('percentage')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('learning_activities', function (Blueprint $table) {
            $table->dropColumn('percentage');
        });
    }
};