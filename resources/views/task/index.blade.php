@extends('layouts.app')

@section('content')
    <task club_id="{{ $club_id }}" tasks="{{ $tasks }}" admin_id="{{ $admin_id  }}"></task>
@endsection
