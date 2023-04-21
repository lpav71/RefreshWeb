@extends('layouts.app')

@section('content')
    <task club_id="{{ $club_id }}" tasks="{{ $tasks }}"></task>
@endsection
