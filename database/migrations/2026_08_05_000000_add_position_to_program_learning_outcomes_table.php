<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_learning_outcomes', function (Blueprint $table) {
            if (!Schema::hasColumn('program_learning_outcomes', 'position')) {
                $table->integer('position')->default(0)->after('plo_category_id');
            }
        });

        // Ensure existing records have a valid position value.
        DB::table('program_learning_outcomes')
            ->whereNull('position')
            ->update(['position' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_learning_outcomes', function (Blueprint $table) {
            if (Schema::hasColumn('program_learning_outcomes', 'position')) {
                $table->dropColumn('position');
            }
        });
    }
};
