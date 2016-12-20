@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager</h1>

    <form id="hotelManagerForm" action="{{ route('hotelManagerCheckAvailability') }}" method="post">
        <div class="form-group">
            <label for="inputLang">Idioma</label>
            <input type="text" class="form-control" id="inputLang" name="lang" value="es">
        </div>
        <div class="form-group">
            <label for="inputHotelsId">Hotels ID (IDs separados por comas)</label>
            <input type="text" class="form-control" id="inputHotelsId" name="hotelIds" value="370,201,379,377">
        </div>
        <div class="form-group">
            <label for="inputCheckInDate">CheckIn Date</label>
            <input type="date" class="form-control" id="inputCheckInDate" name="checkInDate" value="2017-01-15">
        </div>
        <div class="form-group">
            <label for="inputCheckOutDate">CheckOut Date</label>
            <input type="date" class="form-control" id="inputCheckOutDate" name="checkOutDate" value="2017-01-20">
        </div>
        <div class="form-group">
            <label for="inputNumberRooms">Número de habitaciones</label>
            <input type="number" class="form-control" id="inputNumberRooms" name="numberRooms" value="1">
        </div>
        <div class="form-group">
            <label for="inputNumberAdults">Número de adultos</label>
            <input type="number" class="form-control" id="inputNumberAdults" name="numberAdults" value="1">
        </div>
        <div class="form-group">
            <label for="inputNumberChildren">Número de niños</label>
            <input type="number" class="form-control" id="inputNumberChildren" name="numberChildren" value="0">
        </div>

        <input type="hidden" name="action" value="list_disponibilidad">

        <input type="hidden" name="test[]" value="1">
        <input type="hidden" name="test[]" value="2">
        <input type="hidden" name="test[]" value="3">

        <input type="hidden" name="rooms[numberRooms]" value="1">
        <input type="hidden" name="rooms[numberAdults]" value="1">

        <button type="submit" class="btn btn-default">Check Availability</button>
    </form>
@stop