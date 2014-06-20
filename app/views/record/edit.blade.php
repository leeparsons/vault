@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="javascript:history.go(-1);">Go Back</a>
@stop

@section('content')
<section class="edit-record container-fluid">
    {{ Form::open(array('url'   =>  'dashboard/record/' . ($record->id?:-1) . '/edit', 'action' => 'RecordController@save')) }}
    <header class="row show-grid">
        <h1 class="col-xs-12">Editing: {{ $record->record_name }}</h1>
        <span class="record-type col-xs-12 bg-primary">{{ $record->record_type }} {{ Form::hidden('record_type', $record->record_type) }}</span>
    </header>

    <article class="row show-grid">
        <fieldset>
            <div class="form-group">
                {{ Form::text('record_name', Input::old('record_name')?:$record->record_name, array('class'    =>  'form-control')) }}
            </div>
        </fieldset>
        <fieldset>
            {{ App::make('HelperRecordType')->renderFields($record) }}
        </fieldset>
    </article>

    {{ Form::submit('Save', array('class'   =>  'btn btn-success')) }}
    {{ Form::close() }}
</section>
@stop