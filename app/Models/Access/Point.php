<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public $table = "access_points";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
		''id',
		'mac',
		'host',

    ];

    public static $rules = [
        // create rules
    ];

    // Point 
}
