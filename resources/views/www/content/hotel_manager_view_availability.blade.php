@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager</h1>
    @foreach($hotels as $hotel)
        Hotel: {{ $hotel->id }}
        <br><br>

        Habitaciones disponibles:<br>
        @foreach($hotel->rooms as $room)
        <ul>
            <li>ID: {{ $room->id }}</li>
            <li>Name: {{ $room->name }}</li>
            <li>Quantity: {{ $room->quantity }}</li>
        </ul>

        Tarifas:<br>
        <ul>
            <li>Total: {{ $room->rates->rate }}</li>
            <li>Por día: {{ $room->rates->rateAvg }}</li>
            <li>Tarifa no reembolsable: {{ $room->rates->isNotRefundableRate? 'SI' : 'NO' }}</li>
            @if( $room->rates->isNotRefundableRate)
                <li>Descuento por tarifa no reembolsable: {{ $room->rates->notRefundablePercentage }}</li>
            @endif
        </ul>
        <form action="{{ route('hotelManagerOpenTransaction-' . user_lang()) }}" method="post">
            <button type="submit">Reservar</button>
            {{ csrf_field() }}
            <input type="hidden" name="roomId" value="{{ $room->id }}">
            <input type="hidden" name="checkInDate" value="{{ $checkInDate }}">
            <input type="hidden" name="checkOutDate" value="{{ $checkOutDate }}">
            <input type="hidden" name="numberRooms" value="{{ $numberRooms }}">
            <input type="hidden" name="numberAdults" value="{{ $numberAdults }}">
            <input type="hidden" name="numberChildren" value="{{ $numberChildren }}">
        </form>
        <br><br>
        @endforeach
    @endforeach
@stop