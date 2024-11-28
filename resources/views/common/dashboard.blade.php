@extends('layouts.app')

@section('content')
    <dashboard club_id="{{ $club_id }}" user_id="{{ $user_id }}"></dashboard>
@endsection
