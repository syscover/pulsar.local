@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
    <script>
        $(document).ready(function(){
            $('#ckjson').click(function(e){

                $('[name=type]').val('json');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')
                    },
                    data: $('#hotelManagerForm').serialize(),
                    url: '{{ route('hotelManagerCheckAvailability-' . user_lang()) }}',
                    type: 'POST',
                    dataType: "json",
                    success: function (response) {
                        $('#responseJson').val(JSON.stringify(response));
                    },
                    error: function(ts) {
                        console.log(ts);
                    }
                });
            });

            $('#hotelManagerForm').submit(function(e){
                $('[name=type]').val('post');
            });
        });
    </script>
@stop

@section('content')
    <h1>Hotel Manager</h1>

    <form id="hotelManagerForm" action="{{ route('hotelManagerCheckAvailability-' . user_lang()) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="inputLang">Idioma</label>
            <input type="text" class="form-control" id="inputLang" name="lang" value="es">
        </div>
        <div class="form-group">
            <label for="inputHotelsId">Hotels ID (IDs separados por comas)</label>
            <input type="text" class="form-control" id="inputHotelsId" name="hotelIds" value="370,201,379,377,388">
        </div>
        <div class="form-group">
            <label for="inputCheckInDate">CheckIn Date</label>
            <input type="text" class="form-control" id="inputCheckInDate" name="checkInDate" value="2018-01-12">
        </div>
        <div class="form-group">
            <label for="inputCheckOutDate">CheckOut Date</label>
            <input type="text" class="form-control" id="inputCheckOutDate" name="checkOutDate" value="2018-01-14">
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

        <button type="submit" class="btn btn-default">Check Availability POST</button>
        <button type="button" id="ckjson" class="btn btn-default">Check Availability JSON</button>

        <input type="hidden" name="type" value="">

    </form>
    <br>
    <div class="form-group">
        <label for="inputNumberRooms">Respuesta Json</label>
        <textarea class="form-control" id="responseJson"></textarea>
    </div>

@stop