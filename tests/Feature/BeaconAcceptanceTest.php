<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BeaconAcceptanceTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->Beacon = factory(App\Models\Beacon::class)->make([
            'id' => '1',
		'mac' => 'quo',
		'host' => 'et',

        ]);
        $this->BeaconEdited = factory(App\Models\Beacon::class)->make([
            'id' => '1',
		'mac' => 'quo',
		'host' => 'et',

        ]);
        $user = factory(App\Models\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', 'beacons');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('beacons');
    }

    public function testCreate()
    {
        $response = $this->actor->call('GET', 'beacons/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'beacons', $this->Beacon->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('beacons/'.$this->Beacon->id.'/edit');
    }

    public function testEdit()
    {
        $this->actor->call('POST', 'beacons', $this->Beacon->toArray());

        $response = $this->actor->call('GET', '/beacons/'.$this->Beacon->id.'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('beacon');
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'beacons', $this->Beacon->toArray());
        $response = $this->actor->call('PATCH', 'beacons/1', $this->BeaconEdited->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('beacons', $this->BeaconEdited->toArray());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'beacons', $this->Beacon->toArray());

        $response = $this->call('DELETE', 'beacons/'.$this->Beacon->id);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('beacons');
    }

}
