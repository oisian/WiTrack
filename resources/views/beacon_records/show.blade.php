@extends('dashboard', ['pageTitle' => 'BeaconRecords &raquo; Show'])

@section('content')

    <div class="container">
        <div class="col-md-12">

            @foreach($beacon_records as $record)
                    {{$record->id}}
            @endforeach

        </div>
    </div>

@stop
