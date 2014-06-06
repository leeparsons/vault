@extends('layouts.master')
@section('body_tag')
<body class="container">
@stop
@section('left_sidebar')
@parent
<a href="/dashboard/">Go Back</a>
@stop


@section('content')
<section ng-app="recordApp" ng-controller="recordController">

    @if($errors->has())
    @foreach ($errors->all() as $error)
    <div class="error">{{ $error }}</div>
    @endforeach
    @endif

    {{ Form::open(array('url'   =>  'dashboard/record/new', 'action' => 'RecordController@save')) }}
    <header>
        <h1 class="editable">Enter the title for this record: {{ Form::text('record_name', Input::old('record_name'), array('required'  =>  true)) }}</h1>
    <span class="editable">Select Record Type {{ Form::select(
        'record_type',
        array_merge(array('0'    =>  'Select option')),
        Input::old('record_type'),
        array(
            'id'                =>  'record_type',
            'ng-change'         =>  'switchType()',
            'ng-options'        =>  'key as value for (key , value) in typeOptions',
            'ng-model'          =>  'typeOption',
            'required'          =>  1
        )
        ) }}</span>
    </header>

    <article id="fields_wrap" ng-repeat="field in fields">
        @include('record/angular/fields')
    </article>

    {{ Form::submit('Save') }}
    {{ Form::close() }}
    {{ HTML::script('js/record.js') }}
</section>
@stop