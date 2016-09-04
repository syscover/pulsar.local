@extends('www.layouts.default')

@section('title', 'Shopping cart')

@section('head')
    @parent
    <script src="{{ asset('packages/syscover/pulsar/vendor/getaddress/js/jquery.getaddress.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.getAddress({
                id:                         '01',
                type:                       'laravel',
                appName:                    'pulsar',
                token:                      '{{ csrf_token() }}',
                lang:                       '{{ config('app.locale') }}',
                highlightCountrys:          ['ES','US'],

                useSeparatorHighlight:      true,
                textSeparatorHighlight:     '------------------',

                countryValue:               '{{ old('country', isset($customer->country_id_301)? $customer->country_id_301 : null) }}',
                territorialArea1Value:      '{{ old('territorialArea1', isset($customer->territorial_area_1_id_301)? $customer->territorial_area_1_id_301 : null) }}',
                territorialArea2Value:      '{{ old('territorialArea2', isset($customer->territorial_area_2_id_301)? $customer->territorial_area_2_id_301 : null) }}',
                territorialArea3Value:      '{{ old('territorialArea3', isset($customer->territorial_area_3_id_301)? $customer->territorial_area_3_id_301 : null) }}'
            });
        })
    </script>
@stop

@section('content')
    <h1>Checkout (Step 1 - shipping)</h1>

    <!-- heads -->
    <div class="row">
        <div class="col-md-3">
            <h5>Product</h5>
        </div>
        <div class="col-md-1">
            <h5>Price</h5>
        </div>
        <div class="col-md-1">
            <h5>Qty</h5>
        </div>
        <div class="col-md-1">
            <h5>Subtotal</h5>
        </div>
        <div class="col-md-1">
            <h5>Descuento</h5>
        </div>
        <div class="col-md-1">
            <h5>Sub + descuentos</h5>
        </div>
        <div class="col-md-1">
            <h5>Tax %</h5>
        </div>
        <div class="col-md-1">
            <h5>Tax €</h5>
        </div>
        <div class="col-md-1">
            <h5>Total</h5>
        </div>
    </div>
    <!-- /heads -->
    @foreach($cartItems as $item)
        <div class="row">
            <div class="col-md-1">
                <img src="https://c.tadst.com/gfx/750w/sunrise-sunset-sun-calculator.jpg?1" class="img-responsive">
            </div>
            <div class="col-md-2">
                <h4>{{ $item->name }}</h4>
            </div>
            <div class="col-md-1">
                <h5>{{ $item->getPrice() }} € / unit</h5>
            </div>
            <div class="col-md-1">
                <h5>{{ $item->getQuantity() }}</h5>
            </div>
            <div class="col-md-1">
                <h4>{{ $item->getSubtotal() }} €</h4>
            </div>
            <div class="col-md-1">
                <h4>{{ $item->getDiscountAmount() }} €</h4>
            </div>
            <div class="col-md-1">
                <h4>{{ $item->getSubtotalWithDiscounts() }} €</h4>
            </div>
            <div class="col-md-1">
                @foreach($item->getTaxRates() as $taxRate)
                    <h6>{{ $taxRate }} %</h6>
                @endforeach
            </div>
            <div class="col-md-1">
                <h4>{{ $item->getTaxAmount() }} €</h4>
            </div>
            <div class="col-md-1">
                <h4>{{ $item->getTotal() }} €</h4>
            </div>
        </div>
    @endforeach
    <br><br><br><br>
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-7">
                    <h4>Subtotal:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getSubtotal() }} €</h4>
                </div>
            </div>
            @foreach(CartProvider::instance()->getTaxRules() as $taxRule)
                <div class="row">
                    <div class="col-md-7">
                        <h5>{{ $taxRule->name }} ({{ $taxRule->getTaxRate() }}%)</h5>
                    </div>
                    <div class="col-md-5">
                        <h5>{{ $taxRule->getTaxAmount() }} €</h5>
                    </div>
                </div>
            @endforeach

            @foreach(CartProvider::instance()->getPriceRules() as $priceRule)
                <div class="row">
                    @if($priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_SUBTOTAL_PERCENTAGE || $priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_TOTAL_PERCENTAGE)
                    <div class="col-md-7">
                        <h5>{{ $priceRule->name }} ({{ $priceRule->getDiscountPercentage() }}%)</h5>
                    </div>
                    @endif
                    @if($priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_SUBTOTAL_FIXED_AMOUNT || $priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_TOTAL_FIXED_AMOUNT)
                        <div class="col-md-7">
                            <h5>{{ $priceRule->name }} ({{ $priceRule->getDiscountFixed() }} € )</h5>
                        </div>
                    @endif
                    <div class="col-md-5">
                        <h5>{{ $priceRule->getDiscountAmount() }}€</h5>
                    </div>
                </div>
            @endforeach

            <div class="row">
                <div class="col-md-7">
                    <h4>Total Discount:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getDiscountAmount() }} €</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <h4>Total Tax:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getTaxAmount() }} €</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-7">
                    <h4>Coste de envío:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getShippingAmount() }} €</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <h4>Total:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getTotal() }} €</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Shipping: {{ CartProvider::instance()->getShippingAmount() }} €</h3>
            <form action="{{ route('postCheckout01-' . user_lang()) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ empty($customer->name_301)? null : $customer->name_301 }}" required>
                </div>
                <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname" value="{{ empty($customer->surname_301)? null : $customer->surname_301 }}" required>
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" id="country" name="country" required>
                    </select>
                </div>
                <div class="form-group" id="territorialArea1Wrapper">
                    <label for="territorialArea1" id="territorialArea1Label"></label>
                    <select class="form-control" id="territorialArea1" name="territorialArea1">
                    </select>
                </div>
                <div class="form-group" id="territorialArea2Wrapper">
                    <label for="territorialArea2" id="territorialArea2Label"></label>
                    <select class="form-control" id="territorialArea2" name="territorialArea2">
                    </select>
                </div>
                <div class="form-group" id="territorialArea3Wrapper">
                    <label for="territorialArea3" id="territorialArea3Label"></label>
                    <select class="form-control" id="territorialArea3" name="territorialArea3">
                    </select>
                </div>

                <div class="form-group">
                    <label for="cp">CP</label>
                    <input type="text" class="form-control" id="cp" name="cp" placeholder="CP" value="{{ empty($customer->cp_301)? null : $customer->cp_301 }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ empty($customer->address_301)? null : $customer->address_301 }}" required>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Nex step</button>
            </form>
        </div>
    </div>
@stop