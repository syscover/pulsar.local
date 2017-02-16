@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager</h1>
    @foreach($hotels as $hotel)
        <h1>Hotel: {{ $hotel->id }}</h1>
        <br><br>

        Habitaciones disponibles:<br>
        @foreach($hotel->rooms as $room)
        <ul>
            <li>ID: {{ $room->id }}</li>
            <li>Name: {{ $room->name }}</li>
            <li>Quantity: {{ $room->quantity }}</li>
        </ul>

        Tarifas:<br><br>
        <strong>Tarifa reembolsable</strong>
        <ul>
            <li>Total: {{ $room->rates->rate }}</li>
            <li>Por día: {{ $room->rates->rateAvg }}</li>
        </ul>
        <form action="{{ route('hotelManagerOpenTransaction-' . user_lang()) }}" method="post">
            <select name="additionId">
                @foreach($room->additions as $addition)
                    <option value="{{ $addition->id }}">{{ $addition->name }}</option>
                @endforeach
            </select>
            <button type="submit">Reservar reembolsable</button>
            {{ csrf_field() }}
            <input type="hidden" name="roomId" value="{{ $room->id }}">
            <input type="hidden" name="checkInDate" value="{{ $checkInDate }}">
            <input type="hidden" name="checkOutDate" value="{{ $checkOutDate }}">
            <input type="hidden" name="numberRooms" value="{{ $numberRooms }}">
            <input type="hidden" name="numberAdults" value="{{ $numberAdults }}">
            <input type="hidden" name="numberChildren" value="{{ $numberChildren }}">
            <input type="hidden" name="isRefundableRate" value="1">
        </form>
        <br><br>
        @if( $room->rates->hasNonRefundableRate)
            <strong>Tarifa no reembolsable</strong>
            <ul>
                <li>Total no reembolsable: {{ $room->rates->rateNonRefundable }}</li>
                <li>Por día no reembolsable: {{ $room->rates->rateAvgNonRefundable }}</li>
                <li>Descuento por tarifa no reembolsable: {{ $room->rates->nonRefundablePercentageDiscount }}</li>
            </ul>
            <form action="{{ route('hotelManagerOpenTransaction-' . user_lang()) }}" method="post">
                <select name="additionId">
                    @foreach($room->additions as $addition)
                        <option value="{{ $addition->id }}">{{ $addition->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Reservar no reembolsable</button>
                {{ csrf_field() }}
                <input type="hidden" name="roomId" value="{{ $room->id }}">
                <input type="hidden" name="checkInDate" value="{{ $checkInDate }}">
                <input type="hidden" name="checkOutDate" value="{{ $checkOutDate }}">
                <input type="hidden" name="numberRooms" value="{{ $numberRooms }}">
                <input type="hidden" name="numberAdults" value="{{ $numberAdults }}">
                <input type="hidden" name="numberChildren" value="{{ $numberChildren }}">
                <input type="hidden" name="isRefundableRate" value="0">
            </form>
        @endif

        <br><br>
        @endforeach
    @endforeach
@stop