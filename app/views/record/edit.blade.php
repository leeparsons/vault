@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="javascript:history.go(-1);">Go Back</a>
@stop

@section('content')
{{ Form::open(array('url'   =>  'dashboard/record/' . ($record->id?:-1) . '/edit', 'action' => 'RecordController@save')) }}
<header>
    <h1 class="editable">{{ $record->record_name }} {{ Form::text('record_name', Input::old('record_name')?:$record->record_name) }}</h1>
    <span class="editable">{{ $record->record_type }} {{ Form::hidden('record_type', $record->record_type) }}</span>
</header>

<article>
     {{ App::make('HelperRecordType')->renderFields($record) }}
</article>

{{ Form::submit('Save') }}
{{ Form::close() }}
@stop