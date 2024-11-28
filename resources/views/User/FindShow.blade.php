@extends('layouts.app')

@section('content')
    <users club_id="{{ $club_id }}" f_user="{{ $fUser }}" user_id="{{ $user_id }}"></users>
@endsection
