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
            <label for="inputLang">Idioma *</label>
            <input type="text" class="form-control" id="inputLang" name="lang" value="es">
        </div>
        <div class="form-group">
            <label for="inputCheckInDate">CheckIn Date *</label>
            <input type="text" class="form-control" id="inputCheckInDate" name="checkInDate" value="{{ $checkInDate }}">
        </div>
        <div class="form-group">
            <label for="inputCheckOutDate">CheckOut Date *</label>
            <input type="text" class="form-control" id="inputCheckOutDate" name="checkOutDate" value="{{ $checkOutDate }}">
        </div>
        <div class="form-group">
            <label for="inputCheckInHour">Hora llegada</label>
            <input type="text" class="form-control" id="inputCheckInHour" name="checkInHour" value="">
        </div>
        <div class="form-group">
            <label for="inputCheckInMinute">Minuto llegada</label>
            <input type="text" class="form-control" id="inputCheckInMinute" name="checkInMinute" value="">
        </div>
        <div class="form-group">
            <label for="inputNumberRooms">Número de habitaciones *</label>
            <input type="number" class="form-control" id="inputNumberRooms" name="numberRooms" value="{{ $numberRooms }}">
        </div>
        <div class="form-group">
            <label for="inputNumberAdults">Número de adultos *</label>
            <input type="number" class="form-control" id="inputNumberAdults" name="numberAdults" value="{{ $numberAdults }}">
        </div>
        <div class="form-group">
            <label for="inputNumberChildren">Número de niños</label>
            <input type="number" class="form-control" id="inputNumberChildren" name="numberChildren" value="{{ $numberChildren }}">
        </div>

        <hr>

        <div class="form-group">
            <label for="inputName">Nombre *</label>
            <input type="text" class="form-control" id="inputName" name="name" value="">
        </div>
        <div class="form-group">
            <label for="inputSurname">Apellidos *</label>
            <input type="text" class="form-control" id="inputSurname" name="surname" value="">
        </div>
        <div class="form-group">
            <label for="inputPhone">Teléfono *</label>
            <input type="text" class="form-control" id="inputPhone" name="phone" value="">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email *</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="">
        </div>

        <div class="form-group">
            <label for="inputDocType">DocType *</label>
            <select class="form-control" id="inputDocType" name="docType">
                <option value="1">DNI</option>
                <option value="2">NIE</option>
                <option value="3">Pasaporte</option>
                <option value="4">CIF</option>
            </select>
        </div>
        <div class="form-group">
            <label for="inputDocNumber">DocNumber *</label>
            <input type="text" class="form-control" id="inputDocNumber" name="docNumber" value="">
        </div>
        <div class="form-group">
            <label for="inputObservations">Observaciones</label>
            <textarea class="form-control" id="inputObservations" name="observations"></textarea>
        </div>

        <div class="form-group">
            <label for="inputCountry">País</label>
            <select class="form-control" id="inputCountry" name="country">
            </select>
        </div>

        <div class="form-group">
            <label for="inputPayment">Medio de pago *</label>
            <select class="form-control" id="inputPayment" name="payment">
                <option value="1">Visa</option>
                <option value="2">American Express</option>
                <option value="3">Master Card</option>
                <option value="4">Depósito Bancario</option>
            </select>
        </div>
        <div class="form-group">
            <label for="inputCreditCardHolder">Titular Tarjeta de crédito *</label>
            <input type="text" class="form-control" id="inputCreditCardHolder" name="creditCardHolder" value="">
        </div>
        <div class="form-group">
            <label for="inputCreditCard">Número Tarjeta de crédito *</label>
            <input type="text" class="form-control" id="inputCreditCard" name="creditCard" value="">
        </div>
        <div class="form-group">
            <label for="inputDateExpiry">Fecha vencimiento *</label>
            <input type="text" class="form-control" id="inputDateExpiry" name="dateExpiry" value="" placeholder="YYMM">
        </div>
        <div class="form-group">
            <label for="inputCvv">CVV</label>
            <input type="text" class="form-control" id="inputCvv" name="cvv" value="">
        </div>

        <button type="submit" class="btn btn-default">RESERVAR</button>
    </form>
@stop