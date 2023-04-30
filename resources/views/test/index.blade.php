@extends('layouts.app')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Время начала</th>
            <th>Время окончания</th>
            <th>Длительность</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $row['start_time'] }}</td>
                <td>{{ $row['end_time'] }}</td>
                <td>
                    <div class="bar" style="width: {{ getTimeDiff($row['start_time'], $row['end_time']) }};"></div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

<?php
use Carbon\Carbon;
function getTimeDiff($start, $end)
{
    $start_time = Carbon::createFromFormat('H:i', $start);
    $end_time = Carbon::createFromFormat('H:i', $end);
    $diff = $end_time->diffInMinutes($start_time); // разница в минутах
    return ($diff / 60 * 90) . 'px'; // преобразуем в проценты
}
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        color: var(--standart-gray);
    }

    td, th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        width: 60px;
    }

    th {
        background-color: #f2f2f2;
        color: black;
    }

    td .bar {
        background-color: var(--dark-green);
        height: 30px;
        border-radius: 5px 30px 5px 30px;
    }
</style>
