@extends('layouts.master')


@section('left_sidebar')
@parent
{{ HTML::script('js/record.js') }}
<div class="row">
    @if (Auth::User()->canEdit())
    <a href="/dashboard/record/add/" class="btn btn-success pull-right btn-new">Add New Record</a>
    @endif
    {{ Form::open(array('url'   =>  'dashboard/record/search', 'action' => 'RecordController@search', 'method'  =>  'get', 'class'  =>  'col-xs-7 form-inline')) }}

    {{ Form::label('search', 'Find records:') }}

    {{ Form::input('search', 's', Input::get('s'), array('id'   =>  'search', 'class' => 'form-control')) }}

    {{ Form::submit('Search', array('class' =>  'btn btn-success')) }}

    <a href="/dashboard/" class="btn btn-default">Clear Search</a>

    {{ Form::close() }}
</div>
@stop

@section('content')
@if($errors->any())
@foreach ($errors->all() as $error)
<div class="bg-danger">{{ $error }}</div>
@endforeach
@elseif (Session::get('info', '') != '')
<p class="bg-info">{{ Session::get('info') }}</p>
@endif
<h1>Vault Records</h1>

@if (isset($search))
<div class="row">
    <p class="col-xs-12 show-grid">Your search for {{ $search }} returned {{ count($records) }} result{{ count($records) == 1?'':'s' }}.</p>
</div>
@endif
<div class="list-wrap" ng-app="recordViewer" ng-controller="recordViewerController">


    <ul class="wrap" id="record_list">
        @foreach ($records as $i => $record)
        <li class="item-{{ $record->record_type_slug }} record-item" data-id="{{ $record->id }}">
            <a href="" ng-click="updateRecordContent({{ $record->id }});">{{ $record->record_name }}</a>
        </li>
        @endforeach
    </ul>

    <div class="record-content" ng-repeat="record in record_content">
        @if (Auth::user()->canEdit())
        @include('record/angular/edit_link')
        @endif
        @if (Auth::User()->canDelete())
        @include('record/angular/delete_link')
        @endif
        @include('record/angular/content')

    </div>

</div>

@stop