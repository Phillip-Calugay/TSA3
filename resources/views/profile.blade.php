@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>
    @if($user)
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Full name:</strong> {{ $user->full_name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Member since:</strong> {{ $user->created_at?->format('Y-m-d H:i:s') }}</p>
    @else
        <p>No user profile found.</p>
    @endif
@endsection
