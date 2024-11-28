@extends('layouts.app')

@section('content')
    <users-group club_id="{{ $club_id }}" user_id="{{ $user_id }}"></users-group>
@endsection
