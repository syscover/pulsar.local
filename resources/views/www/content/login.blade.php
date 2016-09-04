@extends('www.layouts.default')

@section('title', 'HOME')

@section('head')
@stop

@section('content')
    <h1>Login</h1>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('postLogin') }}">
                {{ csrf_field() }}
                <!--
                    Use input hidden with name responseType to define response type, values:
                    - redirect
                    - json
                -->
                <input type="hidden" name="responseType" value="redirect">
                <div class="form-group">
                    <input type="text" class="form-control" name="user" placeholder="Insert your user">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Insert your password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" value="1"> {{ trans('www.remenber') }}
                    </label>
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
                <button type="submit" class="btn btn-primary btn-lg">{{ trans('www.login') }}</button>
            </form>
            <br>
            <a href="#">{{ trans('www.forget_password') }}</a>
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('getSingIn-' . user_lang()) }}" class="btn btn-primary btn-lg">{{ trans('www.sign_in') }}</a>
        </div>
    </div>
@stop