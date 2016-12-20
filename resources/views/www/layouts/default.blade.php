<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Titulo de la página') - Start Bootstrap Template</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    @yield('head')
</head>

<body>
    <!-- MENU -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home-' . user_lang()) }}">PULSAR</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('home-' . user_lang()) }}">{{ trans('www.home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('productList-' . user_lang()) }}">{{ trans_choice('www.product', 2) }}</a>
                    </li>
                    <li>
                        <a href="{{ route('getShoppingCart-' . user_lang()) }}">{{ trans('www.shopping_cart') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('facturaDirectaClients-' . user_lang()) }}">FD</a>
                    </li>
                    <li>
                        <a href="{{ route('hotelManager-' . user_lang()) }}">HM</a>
                    </li>
                    <li>
                        <a href="#">{{ trans('www.contact') }}</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('www.my_account') }}</a>
                        <ul class="dropdown-menu">
                            @if(auth('crm')->check())
                                <li><a href="{{ route('account-' . user_lang()) }}">{{ trans('www.my_account') }}</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('logout-' . user_lang()) }}">{{ trans('www.logout') }}</a></li>
                            @endif
                            @if(auth('crm')->guest())
                                <li><a href="{{ route('getLogin-' . user_lang()) }}">{{ trans('www.login') }}</a></li>
                            @endif
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans_choice('www.language', 1) }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ get_lang_route('es') }}">{{ trans('www.spanish') }}</a></li>
                            <li><a href="{{ get_lang_route('en') }}">{{ trans('www.english') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /MENU -->

    <div class="container">
        @yield('content')
    </div>

</body>
</html>