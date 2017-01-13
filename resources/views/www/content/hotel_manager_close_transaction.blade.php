@extends('www.layouts.default')

@section('title', 'Hotel Manager - Check Availability')

@section('head')
@stop

@section('content')
    <h1>Hotel Manager - Transaction</h1>

    <ul>
        <li>Booking ID: {{ $booking->id }}</li>
        <li>Booking Key: {{ $booking->key }}</li>
    </ul>
@stop