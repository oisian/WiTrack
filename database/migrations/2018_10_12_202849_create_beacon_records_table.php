<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeaconRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon_records', function (Blueprint $table) {
            $table->increments('id');
			$table->string('reportedFrom');
			$table->string('mac');
			$table->string('type');
			$table->string('timestamp');
            $table->string('signalStrength');
			$table->string('frequency');
			$table->string('shortName')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beacon_records');
    }
}
