@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager - Transaction</h1>

    <form id="hotelManagerForm" action="{{ route('hotelManagerCloseTransaction-' . user_lang()) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="transaction" value="{{ $transaction->id }}">
        <div class="form-group">
            <label for="inputLang">Idioma</label>
            <input type="text" class="form-control" id="inputLang" name="lang" value="es">
        </div>
        <div class="form-group">
            <label for="inputCheckInDate">CheckIn Date</label>
            <input type="text" class="form-control" id="inputCheckInDate" name="checkInDate" value="{{ $checkInDate }}">
        </div>
        <div class="form-group">
            <label for="inputCheckOutDate">CheckOut Date</label>
            <input type="text" class="form-control" id="inputCheckOutDate" name="checkOutDate" value="{{ $checkOutDate }}">
        </div>
        <div class="form-group">
            <label for="inputNumberRooms">Número de habitaciones</label>
            <input type="number" class="form-control" id="inputNumberRooms" name="numberRooms" value="{{ $numberRooms }}">
        </div>
        <div class="form-group">
            <label for="inputNumberAdults">Número de adultos</label>
            <input type="number" class="form-control" id="inputNumberAdults" name="numberAdults" value="{{ $numberAdults }}">
        </div>
        <div class="form-group">
            <label for="inputNumberChildren">Número de niños</label>
            <input type="number" class="form-control" id="inputNumberChildren" name="numberChildren" value="{{ $numberChildren }}">
        </div>

        <hr>

        <div class="form-group">
            <label for="inputName">Nombre</label>
            <input type="text" class="form-control" id="inputName" name="name" value="">
        </div>
        <div class="form-group">
            <label for="inputSurname">Surname</label>
            <input type="text" class="form-control" id="inputSurname" name="surname" value="">
        </div>
        <div class="form-group">
            <label for="inputPhone">Teléfono</label>
            <input type="text" class="form-control" id="inputPhone" name="phone" value="">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="">
        </div>

        <div class="form-group">
            <label for="inputEmail">DOCTYE</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="">
        </div>









        <button type="submit" class="btn btn-default">RESERVAR</button>

        <input type="hidden" name="type" value="">

    </form>
@stop