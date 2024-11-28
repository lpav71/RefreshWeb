@extends('layouts.app')

@section('content')
    <tariffs club_id="{{ $club_id }}" user_id="{{ $user_id }}"></tariffs>
@endsection
