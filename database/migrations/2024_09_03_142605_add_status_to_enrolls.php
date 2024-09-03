<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToEnrolls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrolls', function (Blueprint $table) {
            //
            $table->string('status', 20)->nullable()
                ->after('is_enrolled');
                
            $table->string('school_transfered')->nullable()
                ->after('status');

            $table->date('date_transfered')->nullable()
                ->after('transfered_to');

            $table->text('reason')->nullable()
                ->after('date_transfered');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolls', function (Blueprint $table) {
            //
        });
    }
}
