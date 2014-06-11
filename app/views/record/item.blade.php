@extends('layouts.master')

@section('left_sidebar')
@parent
<a href="/dashboard/">Go Back</a>
@if ($record->canEdit())
<a href="/dashboard/record/{{ $record->id }}/edit">Edit Record</a>
@endif
@stop

@section('content')
<header>
    <h1>{{ $record->record_name }}</h1>
    <span>{{ $record->record_type }}</span>
</header>

<article>

    @if (count($record->getFields()))
    @foreach ($record->getFields() as $id => $field)
    <div class="row">
        {{ $id}}: <pre>{{ $field->value }}</pre>
    </div>
    @endforeach
    @endif
</article>
@stop