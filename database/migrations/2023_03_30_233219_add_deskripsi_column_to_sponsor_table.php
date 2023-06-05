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
        Schema::table('sponsor', function (Blueprint $table) {
            $table->string('deskripsi')->nullable()->after('sponsor');
          
            $table->string('status')->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsor', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
      
            $table->dropColumn('status');
        });
    }
};
