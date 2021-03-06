@extends('layouts.app')
@section('title', $isUpdate ? 'Update Challenge' : 'Upload Challenge')

@section('content')
    <form action="{{ $isUpdate && $challenge ? route('update', $challenge->id) : route('create') }}" method="post">
        @if(\Illuminate\Support\Facades\Session::has('message'))
            <span class="tag is-info is-medium">{{ session('message') }}</span>
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            <span class="tag is-warning is-medium">{{ session('error') }}</span>
        @endif
        <input required class="input" type="text" name="title" placeholder="title" maxlength="64"
               value="{{ $challenge ? $challenge->title : '' }}">
        <input required class="input" type="text" name="model_answer"
               placeholder="model answer (up to 256 letters) which will be passed like `/?${encodeURIComponent(payload)}`"
               maxlength="256">
        <textarea class="textarea" maxlength="1337" name="html" placeholder="html (up to 1337 letters)" {{ $isUpdate ? 'disabled' : '' }}>{{ $isUpdate ? $challenge->html : '' }}</textarea>
        @csrf
        <input class="button" type="submit" value="submit">
    </form>
@endsection
