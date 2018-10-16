<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BeaconService;
use App\Http\Requests\BeaconCreateRequest;
use App\Http\Requests\BeaconUpdateRequest;

class BeaconsController extends Controller
{
    public function __construct(BeaconService $beacon_service)
    {
        $this->service = $beacon_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $beacons = $this->service->paginated();
        return view('beacons.index')->with('beacons', $beacons);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $beacons = $this->service->search($request->search);
        return view('beacons.index')->with('beacons', $beacons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('beacons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BeaconCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeaconCreateRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(route('beacons.edit', ['id' => $result->id]))->with('message', 'Successfully created');
        }

        return redirect(route('beacons.index'))->withErrors('Failed to create');
    }

    /**
     * Display the beacon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beacon = $this->service->find($id);
        return view('beacons.show')->with('beacon', $beacon);
    }

    /**
     * Show the form for editing the beacon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beacon = $this->service->find($id);
        return view('beacons.edit')->with('beacon', $beacon);
    }

    /**
     * Update the beacons in storage.
     *
     * @param  App\Http\Requests\BeaconUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BeaconUpdateRequest $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token'));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->withErrors('Failed to update');
    }

    /**
     * Remove the beacons from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(route('beacons.index'))->with('message', 'Successfully deleted');
        }

        return redirect(route('beacons.index'))->withErrors('Failed to delete');
    }
}
