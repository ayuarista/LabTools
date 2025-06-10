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

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('nis')
                ->constrained('users');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropForeign('student_profiles_user_id_foreign');
            $table->dropColumn('user_id');
            $table->string('name');
        });
    }
};
