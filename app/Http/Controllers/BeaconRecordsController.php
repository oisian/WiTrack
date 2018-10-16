<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BeaconRecordService;
use App\Http\Requests\BeaconRecordCreateRequest;
use App\Http\Requests\BeaconRecordUpdateRequest;

class BeaconRecordsController extends Controller
{
    public function __construct(BeaconRecordService $beacon_record_service)
    {
        $this->service = $beacon_record_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $beacon_records = $this->service->paginated();
        return view('beacon_records.index')->with('beacon_records', $beacon_records);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $beacon_records = $this->service->search($request->search);
        return view('beacon_records.index')->with('beacon_records', $beacon_records);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('beacon_records.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BeaconRecordCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeaconRecordCreateRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(route('beacon_records.edit', ['id' => $result->id]))->with('message', 'Successfully created');
        }

        return redirect(route('beacon_records.index'))->withErrors('Failed to create');
    }

    /**
     * Display the beacon_record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beacon_record = $this->service->find($id);
        return view('beacon_records.show')->with('beacon_record', $beacon_record);
    }

    /**
     * Show the form for editing the beacon_record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $beacon_record = $this->service->find($id);
        return view('beacon_records.edit')->with('beacon_record', $beacon_record);
    }

    /**
     * Update the beacon_records in storage.
     *
     * @param  App\Http\Requests\BeaconRecordUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BeaconRecordUpdateRequest $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token'));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->withErrors('Failed to update');
    }

    /**
     * Remove the beacon_records from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(route('beacon_records.index'))->with('message', 'Successfully deleted');
        }

        return redirect(route('beacon_records.index'))->withErrors('Failed to delete');
    }
}
