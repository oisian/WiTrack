<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeaconRecord extends Model
{
    public $table = "beacon_records";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
        'reportedFrom',
        'mac',
        'type',
        'timestamp',
        'signalStrength',
        'frequency',
        'shortName'
    ];

    public static $rules = [
        // create rules
    ];

    // BeaconRecord
}
