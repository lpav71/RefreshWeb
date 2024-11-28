@extends('layouts.app')

@section('content')
    <maps club_id="{{ $club_id }}" comps="{{ $comps }}"></maps>
@endsection
