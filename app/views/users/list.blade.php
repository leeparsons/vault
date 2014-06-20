@extends('layouts.master')

@section('left_sidebar')
<div class="row">
    @if (Auth::User()->isAdmin())
    <a href="/dashboard/user/add/" class="btn btn-success pull-right btn-new">Add New User</a>
    @endif
    {{ Form::open(array('url'   =>  'dashboard/users/search', 'action' => 'UserController@search', 'method' =>  'get', 'class'  =>  'col-xs-7 form-inline')) }}

    {{ Form::label('search', 'Search users:') }}

    {{ Form::input('search', 'search', Input::get('search'), array('placeholder' =>  'Search...', 'class'  =>  'form-control')) }}

    {{ Form::submit('Search', array('class'  =>  'btn btn-success')) }}

    <a href="/dashboard/users" class="btn btn-default">Clear Search</a>

    {{ Form::close() }}
</div>
@stop

@section('content')
<div class="row-fluid">

    @if (isset($search))
    <div class="row">
        <p class="col-xs-12 show-grid">Your search for {{ $search }} returned {{ count($users) }} user{{ count($users) == 1?'':'s' }}.</p>
    </div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Level</th>
            <th>Last Active</th>
            <th>Last Login</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
        <tr>
            <td>
                <a href="/dashboard/user/{{ $user->id }}">{{$user->username}}</a>
            </td>

            <td>
                <a href="/dashboard/user/{{ $user->id }}">{{ $user->email }}</a>
            </td>
            <td>
                <a href="/dashboard/user/{{ $user->id }}">{{ $user->userRoles->last()->role->information }}</a>
            </td>

            <td>
                <a href="/dashboard/user/{{ $user->id }}">{{ $user->getPeriodSinceActive() }}</a>
            </td>

            <td>
                <a href="/dashboard/user/{{ $user->id }}">{{ $user->getPeriodSinceLogin() }}</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop

