@extends('dashboard', ['pageTitle' => 'BeaconRecords &raquo; Index'])

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right raw-margin-top-24 raw-margin-left-24">
                {!! Form::open(['route' => 'beacon_records.search']) !!}
                <input class="form-control form-inline pull-right" name="search" placeholder="Search">
                {!! Form::close() !!}
            </div>
            <h1 class="pull-left">BeaconRecords</h1>
            <a class="btn btn-primary pull-right raw-margin-top-24 raw-margin-right-8" href="{!! route('beacon_records.create') !!}">Add New</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if ($beacon_records->isEmpty())
                <div class="well text-center">No beaconRecords found.</div>
            @else
                <table class="table table-striped">
                    <thead>
                    <th>Reported From</th>
                    <th>Mac Address</th>
                    <th>Wifi Type</th>
                    <th>Timestamp</th>
                    <th>Frequency</th>
                    <th>Shortname</th>

                        <th class="text-right" width="200px">Action</th>
                    </thead>
                    <tbody>
                        @foreach($beacon_records as $beacon_record)
                            <tr>
                                <td>{{ $beacon_record->reportedFrom }}</td>
                                <td>{{ $beacon_record->mac }}</td>
                                <td>{{ $beacon_record->type }}</td>
                                <td>{{ $beacon_record->timestamp}}</td>
                                <td>{{ $beacon_record->frequency }}</td>
                                <td>{{ $beacon_record->shortName }}</td>

                                <td>
                                    <a href="{!! route('beacon_records.edit', [$beacon_record->id]) !!}">{{ $beacon_record->name }}</a>
                                </td>
                                <td class="text-right">
                                    <form method="post" action="{!! route('beacon_records.destroy', [$beacon_record->id]) !!}">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-xs pull-right" type="submit" onclick="return confirm('Are you sure you want to delete this beacon_record?')"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                    <a class="btn btn-default btn-xs pull-right raw-margin-right-16" href="{!! route('beacon_records.edit', [$beacon_record->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            {!! $beacon_records; !!}
        </div>
    </div>

@stop
