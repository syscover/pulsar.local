@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
    <script>
        $(document).ready(function(){

        });
    </script>
@stop

@section('content')
    <h1>Hotel Manager</h1>
    @foreach($hotels as $hotel)
        Hotel: {{ $hotel->id }}<br>
        Habitaciones disponibles:<br>
        @foreach($hotel->rooms as $room)
        <ul>
            <li>ID: {{ $room->id }}</li>
            <li>Name: {{ $room->name }}</li>
            <li>Quantity: {{ $room->quantity }}</li>
        </ul>
        Tarifas:<br>
        <ul>
            <li>Tarifa: {{ $room->rates->rate }}</li>
            <li>Total: {{ $room->rates->rack }}</li>
            <li>Por día: {{ $room->rates->rackAvg }}</li>
        </ul>
        <form>
            <button>Reservar</button>
        </form>
        <br><br>
        @endforeach
    @endforeach
@stop