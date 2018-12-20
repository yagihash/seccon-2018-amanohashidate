@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <table class="table is-fullwidth">
        <thead>
        <tr>
            <th>name</th>
            <th>value</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>id</td>
            <td>{{ $user->id }}</td>
        </tr>
        </tbody>
        <tr>
            <td>name</td>
            <td>{{ $user->name }}</td>
        </tr>
    </table>
    <h3 class="title is-3">Your Challenges (Recent 20)</h3>
    <table class="table is-fullwidth is-striped">
        <thead>
        <th>status</th>
        <th>id</th>
        <th>title</th>
        </thead>
        <tbody>
        @foreach( $challenges as $challenge)
            <tr>
                <td>
                    @if( $challenge->status === \App\Challenge::$status_none)
                        <span class="tag is-info">IN QUEUE</span>
                    @elseif( $challenge->status === \App\Challenge::$status_verified)
                        <span class="tag is-success">VERIFIED</span>
                    @elseif( $challenge->status === \App\Challenge::$status_solved)
                        <span class="tag is-warning">SOLVED</span>
                    @elseif( $challenge->status === \App\Challenge::$status_failed)
                        <span class="tag is-danger">FAILED</span>
                    @endif
                </td>
                <td>{{ $challenge->id }}</td>
                <td>{{ $challenge->title }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
