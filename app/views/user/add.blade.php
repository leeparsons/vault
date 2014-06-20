@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="/dashboard/users/" class="btn btn-danger">Go Back</a>
@stop


@section('content')
<section class="container-fluid">

    @if($errors->has())
    @foreach ($errors->all() as $error)
    <div class="error">{{ $error }}</div>
    @endforeach
    @endif

    {{ Form::open(array('url'   =>  'dashboard/user/add', 'action' => 'UserController@actionSave')) }}
    <header class="row">
        <h1 class="editable col-xs-12 form-group">
            <label for="record_name">Enter the username for this user:</label>
            {{
            Form::text(
            'username',
            Input::old('username'),
            array(
            'required'      =>  true,
            'id'            =>  'username',
            'class'         =>  'form-control',
            'placeholder'   =>  'User Name',
            'required'          =>  1
            ))

            }}</h1>
    <span class="editable col-xs-12 form-group"><label for="record_type">Select User Type</label>{{

        Form::select(
            'role',
            App::make('Role')->get()->lists('information', 'id'),
            Input::old('role'),
            array(
                'id'                =>  'role',
                'required'          =>  1,
                'class'             =>  'form-control show-grid'
            )
        ) }}</span>
    </header>

    <div class="row">


        <div class="form-group col-xs-12">
            <label for="email">Email Address:</label>
            {{
            Form::text(
            'email',
            Input::old('email'),
            array(
            'placeholder'   =>  'Email Address',
            'id'            =>  'email',
            'class'         =>  'form-control',
            'required'          =>  1
            )
            )
            }}
        </div>

        <div class="form-group col-xs-12">
            <label for="email">Password:</label>
            {{
            Form::text(
            'password',
            Input::old('password'),
            array(
            'placeholder'   =>  'Password',
            'id'            =>  'password',
            'class'         =>  'form-control',
            'required'          =>  1
            )
            )
            }}
            <br>
            {{
            Form::button(
            'Generate Password',
            array(
            'id'    =>  'generate_password',
            'class' =>  'btn btn-primary',

            )
            ) }}
        </div>

    </div>
    {{ Form::submit('Create', array('class'   =>  'btn-success btn pull-right')) }}
    {{ Form::close() }}
</section>
{{ HTML::script('js/password.js') }}
@stop