@extends('www.layouts.default')

@section('title', 'Shopping cart')

@section('head')
    @parent
@stop

@section('content')
    <h1>Checkout (Step 3 - payment)</h1>

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
            @if(CartProvider::instance()->hasItemTransportable())
                <div class="row">
                    <div class="col-md-7">
                        <h4>Coste de envío:</h4>
                    </div>
                    <div class="col-md-5">
                        <h4>{{ CartProvider::instance()->getShippingAmount() }} €</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-7">
                    <h4>Total:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getTotal() }} €</h4>
                </div>
            </div>
            <h3>Payment</h3>
            <form action="{{ route('postCheckout03-' . user_lang()) }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="responseType" value="redirect"> <!-- flag to instance response type, json or redirect -->
                <input type="hidden" name="newCustomer" value="error"> <!-- flag to instance that we do if customer does not exist, create or error -->
                @foreach($paymentMethods as $paymentMethod)
                    <div class="radio">
                        <label>
                            <input type="radio" name="paymentMethod" value="{{ $paymentMethod->id_115 }}">
                            {{ $paymentMethod->name_115 }}
                        </label>
                    </div>
                @endforeach
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Pay</button>
            </form>
        </div>
        <div class="col-md-6">
            <!-- check if cart has shipping -->
            @if(CartProvider::instance()->hasItemTransportable())
                <h3>Shipping: {{ CartProvider::instance()->getShippingAmount() }} €</h3>
                <div class="form-group">
                    <label>Name</label><br>
                    {{ $shippingData['name'] }}
                </div>
                <div class="form-group">
                    <label>Surname</label><br>
                    {{ $shippingData['surname'] }}
                </div>

                <div class="form-group">
                    <label>Country</label><br>
                    {{ $shippingCountry->name_002 }}
                </div>
                @if(isset($shippingTA1))
                    <div class="form-group">
                        <label>{{ $shippingCountry->territorial_area_1_002 }}</label><br>
                        {{ $shippingTA1->name_003 }}
                    </div>
                @endif
                @if(isset($shippingTA2))
                    <div class="form-group">
                        <label>{{ $shippingCountry->territorial_area_2_002 }}</label><br>
                        {{ $shippingTA2->name_004 }}
                    </div>
                @endif
                @if(isset($shippingTA3))
                    <div class="form-group">
                        <label>{{ $shippingCountry->territorial_area_3_002 }}</label><br>
                        {{ $shippingTA2->name_005 }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="cp">CP</label><br>
                    {{ $shippingData['cp'] }}
                </div>
                <div class="form-group">
                    <label for="address">Address</label><br>
                    {{ $shippingData['address'] }}
                </div>
            @endif

            @if(CartProvider::instance()->hasInvoice())
                <h3>Invoice </h3>
                <div class="form-group">
                    <label>Name</label><br>
                    {{ $invoice['company'] }}
                </div>
                <div class="form-group">
                    <label>Name</label><br>
                    {{ $invoice['tin'] }}
                </div>
                <div class="form-group">
                    <label>Name</label><br>
                    {{ $invoice['name'] }}
                </div>
                <div class="form-group">
                    <label>Surname</label><br>
                    {{ $invoice['surname'] }}
                </div>

                <div class="form-group">
                    <label>Country</label><br>
                    {{ $invoiceCountry->name_002 }}
                </div>
                @if(isset($invoiceTA1))
                    <div class="form-group">
                        <label>{{ $invoiceCountry->territorial_area_1_002 }}</label><br>
                        {{ $invoiceTA1->name_003 }}
                    </div>
                @endif
                @if(isset($invoiceTA2))
                    <div class="form-group">
                        <label>{{ $invoiceCountry->territorial_area_2_002 }}</label><br>
                        {{ $invoiceTA2->name_004 }}
                    </div>
                @endif
                @if(isset($invoiceTA3))
                    <div class="form-group">
                        <label>{{ $invoiceCountry->territorial_area_3_002 }}</label><br>
                        {{ $invoiceTA3->name_005 }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="cp">CP</label><br>
                    {{ $invoice['cp'] }}
                </div>
                <div class="form-group">
                    <label for="address">Address</label><br>
                    {{ $invoice['address'] }}
                </div>
            @endif
        </div>
    </div>
@stop