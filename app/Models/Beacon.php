<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    public $table = "beacons";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		'id',
		'mac',
		'host',
        'lastRead',
        'active'
    ];

    public static $rules = [
        // create rules
    ];

    // Beacon
}
