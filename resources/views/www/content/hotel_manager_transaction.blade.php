@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager - Transaction</h1>

    <form id="hotelManagerForm" action="{{ route('hotelManagerCloseTransaction-' . user_lang()) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="transactionId" value="{{ $transaction->id }}">
        <input type="hidden" name="additionId" value="{{ $additionId }}">
        <input type="hidden" name="isRefundableRate" value="{{ $isRefundableRate }}">
        <input type="hidden" name="hotelId" value="{{ $hotelId }}">

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
            <input type="text" class="form-control" id="inputCheckInHour" name="checkInHour" value="12">
        </div>
        <div class="form-group">
            <label for="inputCheckInMinute">Minuto llegada</label>
            <input type="text" class="form-control" id="inputCheckInMinute" name="checkInMinute" value="00">
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
            <input type="text" class="form-control" id="inputName" name="name" value="Carlos">
        </div>
        <div class="form-group">
            <label for="inputSurname">Apellidos *</label>
            <input type="text" class="form-control" id="inputSurname" name="surname" value="Palacin">
        </div>
        <div class="form-group">
            <label for="inputPhone">Teléfono *</label>
            <input type="text" class="form-control" id="inputPhone" name="phone" value="+349155555555">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email *</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="cpalacin@syscover.com">
        </div>

        <div class="form-group">
            <label for="inputDocType">DocType *</label>
            <select class="form-control" id="inputDocType" name="docType">
                @foreach($docTypes as $docType)
                    <option value="{{ $docType->id }}">{{ $docType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inputDocNumber">DocNumber *</label>
            <input type="text" class="form-control" id="inputDocNumber" name="docNumber" value="66666666S">
        </div>
        <div class="form-group">
            <label for="inputObservations">Observaciones</label>
            <textarea class="form-control" id="inputObservations" name="observations">
                Hola mundo
            </textarea>
        </div>

        <div class="form-group">
            <label for="inputCountry">País</label>
            <select class="form-control" id="inputCountry" name="country">
                @foreach($countries as $country)
                    <option value="{{ $country->id_002 }}">{{ $country->name_002 }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="inputPayment">Medio de pago *</label>
            <select class="form-control" id="inputPayment" name="paymentMethod">
                @foreach($paymentMethods as $paymentMethod)
                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inputCreditCardHolder">Titular Tarjeta de crédito *</label>
            <input type="text" class="form-control" id="inputCreditCardHolder" name="creditCardHolder" value="Carlos">
        </div>
        <div class="form-group">
            <label for="inputCreditCardNumber">Número Tarjeta de crédito *</label>
            <input type="text" class="form-control" id="inputCreditCardNumber" name="creditCardNumber" value="1111111111111111">
        </div>
        <div class="form-group">
            <label for="inputCreditCardDateExpiry">Fecha vencimiento *</label>
            <input type="text" class="form-control" id="inputCreditCardDateExpiry" name="creditCardDateExpiry" value="1712" placeholder="YYMM">
        </div>
        <div class="form-group">
            <label for="inputCvv">CVV</label>
            <input type="text" class="form-control" id="inputCvv" name="cvv" value="123">
        </div>

        <button type="submit" class="btn btn-default">RESERVAR</button>
    </form>
@stop