@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="/dashboard/users">Go Back</a>
@if (Auth::User()->isAdmin())
<a href="/dashboard/user/{{ $user->id }}/edit">Edit User</a>
@endif
@stop

@section('content')
<header>
    <h1>{{ $user->username }}</h1>
    <span>{{ $user->email }}</span>
</header>

<article>

    @foreach( $user->userRoles as $role )
        {{ $role->role->information }}
    @endforeach

</article>
@stop