<?php
/*
|--------------------------------------------------------------------------
| BeaconRecord Factory
|--------------------------------------------------------------------------
*/

$factory->define(App\Models\BeaconRecord::class, function (Faker\Generator $faker) {
    return [
        'id' => '1',
		'reportedFrom' => 'temporibus',
		'mac' => 'aut',
		'type' => 'eum',
		'timestamp' => 'consequatur',
		'frequency' => 'harum',
		'shortName' => 'dignissimos',
    ];
});
