@extends('layouts.app')

@section('content')
    <licenses club_id="{{ $club_id }}" user_id="{{ $user_id }}"></licenses>
@endsection
