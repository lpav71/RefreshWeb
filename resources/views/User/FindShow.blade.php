@extends('layouts.app')

@section('content')
    <users club_id="{{ $club_id }}" full_name="{{ $fullName }}" f_user="{{ $fUser }}"></users>
@endsection
