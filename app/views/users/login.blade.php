@extends('layouts.master')

@section('content')
<div class="login">
{{ Form::open(array('url'   =>  'user/authenticate', 'action' => 'UserController@authenticate')) }}
@if($errors->has())
@foreach ($errors->all() as $error)
<div class="error">{{ $error }}</div>
@endforeach
@endif
{{ Form::label('username', 'Username') }}
{{ Form::text('username', Input::old('username'), array('placeholder' =>  'username')) }}
{{ Form::label('password', 'Password') }}
{{ Form::password('password') }}
{{ Form::submit('Login') }}
{{ Form::close() }}
</div>
@stop

