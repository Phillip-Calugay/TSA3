@extends('layouts.app')

@section('title', "Today's Tasks")

@section('content')
    <h1>Today's Tasks</h1>
    <p class="muted">{{ today()->format('F j, Y') }}</p>
    @include('partials.task-table', ['emptyMessage' => 'No tasks are scheduled for today.'])
@endsection
