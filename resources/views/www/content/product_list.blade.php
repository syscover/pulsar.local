@extends('www.layouts.default')

@section('title', 'Products list')

@section('head')
@stop

@section('content')
    <h1>{{ trans_choice('www.product', 2) }}</h1>
    @foreach($products as $product)
        <div class="row">
            <div class="col-md-12">
                <h3>
                    <a href="{{ route('product-'. user_lang(), ['category' => $product->mappedCategory->slug_110, 'slug' => $product->slug_112]) }}">{{ $product->name_112 }}</a>
                </h3>
                {!! $product->description_112 !!}
                <br>
                {{ $product->getPrice() }} €<br>

                @if(config('market.taxProductDisplayPrices') == \Syscover\ShoppingCart\Cart::PRICE_WITH_TAX)
                    <small><strong>{{ trans_choice('market::pulsar.tax_included', 1) }} ({{ $product->getTaxAmount() }}€)</strong></small>
                @endif
                @if(config('market.taxProductDisplayPrices') == \Syscover\ShoppingCart\Cart::PRICE_WITHOUT_TAX)
                    <small><strong>{{ trans_choice('market::pulsar.tax_not_included', 1) }} ({{ $product->getTaxAmount() }}€)</strong></small>
                @endif
                @foreach($product->taxRules as $taxRule)
                    <br>
                    <small>{{ trans($taxRule->translation_104) }} {{ $taxRule->getTaxRate() }}%</small>
                @endforeach
                <br><br>
                <a href="{{ route('product-'. user_lang(), ['category' => $product->mappedCategory->slug_110, 'slug' => $product->slug_112]) }}">{{ trans('www.show_product') }}</a>
                <br>
                <a href="{{ route('postShoppingCart-' . user_lang(), ['slug' => $product->slug_112]) }}">{{ trans('www.add_to_shopping_cart') }}</a>
                <hr>
            </div>
        </div>
    @endforeach
@stop