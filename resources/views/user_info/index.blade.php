@extends('layouts.app')

@section('content')
    <user-info user="{{ $user }}" club_id="{{ $club_id }}"></user-info>
@endsection
