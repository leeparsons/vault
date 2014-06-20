@extends('layouts.master')
@section('body_tag')
<body class="container">
@stop
@section('left_sidebar')
@parent
<a href="/dashboard/" class="btn btn-danger">Go Back</a>
@stop


@section('content')
<section ng-app="recordApp" ng-controller="recordController" class="container-fluid">

    @if($errors->has())
    @foreach ($errors->all() as $error)
    <div class="error">{{ $error }}</div>
    @endforeach
    @endif

    {{ Form::open(array('url'   =>  'dashboard/record/new', 'action' => 'RecordController@save')) }}
    <header class="row">
        <h1 class="editable" class="col-xs-12 form-group">
            <label for="record_name">Enter the title for this record:</label>
            {{
            Form::text(
            'record_name',
            Input::old('record_name'),
            array(
                'required'      =>  true,
                'id'            =>  'record_name',
                'class'         =>  'form-control',
                'placeholder'   =>  'Record Name'
            ))

            }}</h1>
    <span class="editable" class="col-xs-12 form-group"><label for="record_type">Select Record Type</label>{{ Form::select(
        'record_type',
        array_merge(array('0'    =>  'Select option')),
        Input::old('record_type'),
        array(
            'id'                =>  'record_type',
            'ng-change'         =>  'switchType()',
            'ng-options'        =>  'key as value for (key , value) in typeOptions',
            'ng-model'          =>  'typeOption',
            'required'          =>  1,
            'class'             =>  'form-control show-grid'
        )
        ) }}</span>
    </header>

    <div ng-repeat="field in fields" class="form-group row">
        @include('record/angular/fields')
    </div>

    {{ Form::submit('Save', array('class'   =>  'btn-success btn')) }}
    {{ Form::close() }}
    {{ HTML::script('js/record.js') }}
</section>
@stop