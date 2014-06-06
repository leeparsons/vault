@extends('layouts.master')


@section('left_sidebar')
@parent
{{ HTML::script('js/record.js') }}

@if (App::make('record')->canEdit())
<a href="/dashboard/record/add/">Add New Record</a>
@endif
{{ Form::open(array('url'   =>  'dashboard/record/search', 'action' => 'RecordController@search', 'method'  =>  'get')) }}
{{ Form::label('search', 'Find records:') }}
{{ Form::input('search', 's', Input::get('s'), array('id'   =>  'search')) }}
{{ Form::submit('Search') }}
<a href="/dashboard/">Clear Filters</a>
{{ Form::close() }}
@stop

@section('content')

<h1>Vault Records</h1>

@if (isset($search))

Your search for {{ $search }} returned {{ count($records) }} result(s).

@endif
<div class="list-wrap" ng-app="recordViewer" ng-controller="recordViewerController">

    <ul class="wrap" id="record_list">
        @foreach ($records as $i => $record)
        <li class="item-{{ $i%2==0?'odd':'even' }}" data-id="{{ $record->id }}">
            <a href="" ng-click="updateRecordContent({{ $record->id }});">{{ $record->record_name }}</a>
        </li>
        @endforeach
    </ul>

    <div class="record-content" ng-repeat="record in record_content">
        @if (User::isPrivaledged())
        @include('record/angular/edit_link')
        @endif
        @include('record/angular/content')

    </div>

</div>

@stop