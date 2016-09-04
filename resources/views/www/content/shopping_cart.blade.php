@extends('www.layouts.default')

@section('title', 'Shopping cart')

@section('head')
    <script>
        $(document).ready(function() {

            $(".increase, .decrease").on('click', function() {
                var input = $(this).siblings('input[type=number]');
                if ($(this).hasClass('increase'))
                {
                    input.val(parseInt(input.val()) + 1);
                }
                else if($(this).hasClass('decrease') && input.val() > 0)
                {
                    input.val(parseInt(input.val()) - 1);
                }
                $('#shoppingCartForm').submit();
            });

            $("#couponCodeBt").on('click', function() {
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: '{{ route('checkCouponCode-' . user_lang()) }}',
                    data: {
                        couponCode: $('[name=couponCode]').val()
                    },
                    success: function (data) {
                        if(data.status == 'success')
                        {
                            $('[name=applyCouponCode]').val($('[name=couponCode]').val());
                            $('#shoppingCartForm').submit();
                        }
                        else
                        {
                            var message = "<h4 class='aligncenter blue-text'>Se han encontrado los siguientes errores</h4>" +
                                    "<ul>";
                            $.each(data.errors, function (index, object) {
                                message += "<li>" + object.trans + "</li>";
                            });
                            message += "</ul>";

                            // function to set text in modal alert
                            $('#couponTextMessage').html(message);

                            // function to show modal
                            $('#couponMessageModal').modal('show');

                            setTimeout(function(){
                                $('#couponMessageModal').modal('hide');
                            }, 10000);
                        }
                    }
                });
            });
        });
    </script>
@stop

@section('content')
    <h1>{{ trans('www.shopping_cart') }}</h1>

    <!-- heads -->
    <div class="row">
        <div class="col-md-3">
            <h5>{{ trans_choice('www.product', 2) }}</h5>
        </div>
        <div class="col-md-1">
            <h5>{{ trans_choice('www.price', 2) }}</h5>
        </div>
        <div class="col-md-1">
            <h5>Qty</h5>
        </div>
        <div class="col-md-1">
            <h5>Subtotal</h5>
        </div>
        <div class="col-md-1">
            <h5>{{ trans_choice('www.discount', 2) }}</h5>
        </div>
        <div class="col-md-1">
            <h5>Sub + {{ trans_choice('www.discount', 2) }}</h5>
        </div>
        <div class="col-md-1">
            <h5>{{ trans_choice('www.tax', 2) }} %</h5>
        </div>
        <div class="col-md-1">
            <h5>{{ trans_choice('www.tax', 2) }} €</h5>
        </div>
        <div class="col-md-1">
            <h5>Total</h5>
        </div>
        <div class="col-md-1">
            <h5>{{ trans('www.delete') }}</h5>
        </div>
    </div>
    <!-- /heads -->

    <form id="shoppingCartForm" action="{{ route('putShoppingCart-' . user_lang()) }}" method="post">
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
                    <input class="hidden" type="number" name="{{ $item->rowId }}" value="{{ $item->getQuantity() }}">
                    <a href="#" class="increase"><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="#" class="decrease"><i class="glyphicon glyphicon-minus"></i></a>
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
                <div class="col-md-1">
                    <a href="{{ route('deleteShoppingCart-' . user_lang(), ['rowId' => $item->rowId]) }}">
                        <i class="glyphicon glyphicon-remove"></i>
                    </a>
                </div>
            </div>
        @endforeach
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="applyCouponCode">
    </form>
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
                        <h4>{{ $taxRule->name }} ({{ $taxRule->getTaxRate() }}%)</h4>
                    </div>
                    <div class="col-md-5">
                        <h4>{{ $taxRule->getTaxAmount() }} €</h4>
                    </div>
                </div>
            @endforeach

            @foreach(CartProvider::instance()->getPriceRules() as $priceRule)
                <div class="row">
                    @if($priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_SUBTOTAL_PERCENTAGE || $priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_TOTAL_PERCENTAGE)
                    <div class="col-md-7">
                        <h4>{{ $priceRule->name }} ({{ $priceRule->getDiscountPercentage() }}%)</h4>
                    </div>
                    @endif
                    @if($priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_SUBTOTAL_FIXED_AMOUNT || $priceRule->discountType == \Syscover\ShoppingCart\PriceRule::DISCOUNT_TOTAL_FIXED_AMOUNT)
                        <div class="col-md-7">
                            <h4>{{ $priceRule->name }} ({{ $priceRule->getDiscountFixed() }} € )</h4>
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
            {{--<div class="row">--}}
                {{--<div class="col-md-7">--}}
                    {{--<h4>Coste de envío:</h4>--}}
                {{--</div>--}}
                {{--<div class="col-md-5">--}}
                    {{--<h3>{{ CartProvider::instance()->getShippingAmount() }} €</h3>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-7">--}}
                    {{--<h4>Coupon name</h4>--}}
                {{--</div>--}}
                {{--<div class="col-md-5">--}}
                    {{--<h3>-9999€</h3>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row">
                <div class="col-md-7">
                    <h4>Total Without shipping:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getCartItemsTotal() }} €</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <h4>Total Without shipping and without discount:</h4>
                </div>
                <div class="col-md-5">
                    <h4>{{ CartProvider::instance()->getCartItemsTotalWithoutDiscounts() }} €</h4>
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
            <div class="row">
                <form>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="couponCode" placeholder="{{ trans('www.coupon_code') }}">
                    </div>
                    <div class="col-md-5">
                        <a class="btn btn-primary" id="couponCodeBt" href="#">{{ trans('www.apply') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <br>
        <div class="col-md-12">
            <a class="btn btn-default" href="{{ route('productList-' . user_lang()) }}">{{ trans('www.continue_shopping') }}</a>
        </div>
    </div>
    @if($cartItems->count() > 0)
    <div class="row">
        <br>
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{ route('getCheckout01-' . user_lang()) }}">{{ trans('www.checkout') }}</a>
        </div>
    </div>
    @endif

    <!-- modal coupon message -->
    <div class="modal fade" id="couponMessageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="couponTextMessage" class="col-md-12 "></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal coupon message -->
@stop