@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <h1>All Tasks</h1>
    <p class="muted">Every task, ordered by date.</p>
    @include('partials.task-table', ['emptyMessage' => 'No tasks found.'])
@endsection
