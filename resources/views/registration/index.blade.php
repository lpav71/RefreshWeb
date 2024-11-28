@extends('layouts.empty')

@section('content')
    <registration club_id="{{ $club_id }}" email="{{ $email }}" user_id="{{ $idUser }}"></registration>
@endsection
