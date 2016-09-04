@extends('www.layouts.default')

@section('title', 'Product')

@section('head')
@stop

@section('content')
    <h1>{{ $product->name_112 }}</h1>

    @if($attachments->count() > 0)
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($attachments as $index => $attachment)
                    <li data-target="#myCarousel" data-slide-to="{{ $index }}" @if($index == 0) class="active" @endif ></li>
                @endforeach
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <div class="carousel-inner" role="listbox">
                @foreach($attachments as $index => $attachment)
                    <div class="item @if($index == 0) active @endif">
                        <img src="{{ asset('packages/syscover/market/storage/attachment/' . $product->id_111 . '/' . $product->lang_id_112 . '/' . $attachment->file_name_016) }}" alt="">
                    </div>
                @endforeach
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @endif

    {!! $product->description_112 !!}

    <br><br>
    <a href="{{ route('postShoppingCart-' . user_lang(), ['slug' => $product->slug_112]) }}">
        {{ trans('www.add_to_shopping_cart') }}
    </a>
@stop