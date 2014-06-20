@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="/dashboard/" class="btn btn-success">Cancel</a>
@stop

@section('content')
<section class="delete-record container-fluid">

    {{ Form::open(array('url'   =>  'dashboard/record/' . ($record->id?:-1) . '/delete', 'action' => 'RecordController@actionDeleteRecord')) }}
    <header class="row show-grid">
        <h1 class="col-xs-12">Confirm Deletion of:<br> {{ $record->record_name }}</h1>
        <span class="record-type col-xs-12 bg-primary">{{ $record->record_type }} {{ Form::hidden('record_type', $record->record_type) }}</span>
    </header>

    {{ Form::submit('Delete', array('class' =>  'btn btn-danger override')) }}
    {{ Form::close() }}
</section>
@stop