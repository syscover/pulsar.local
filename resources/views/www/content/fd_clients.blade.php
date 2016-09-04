@extends('www.layouts.default')

@section('title', 'Factura directa - Clients')

@section('head')
@stop

@section('content')
    <h1>Factura Directa - Clients</h1>
    @foreach($clients as $client)
        <div class="row">
            <div class="col-md-1">{{ is_array($client['companyCode'])? implode($client['companyCode']) : $client['companyCode'] }}</div>
            <div class="col-md-5">{{ is_array($client['name'])? implode($client['name']) : $client['name'] }}</div>
            <div class="col-md-3">{{ is_array($client['tradeName'])? implode($client['tradeName']) : $client['tradeName'] }}</div>
            <div class="col-md-1">{{ is_array($client['address']['country'])? implode($client['address']['country']) : $client['address']['country'] }}</div>
            <div class="col-md-1">{{ is_array($client['email'])? implode($client['email']) : $client['email'] }}</div>
        </div>
    @endforeach
@stop