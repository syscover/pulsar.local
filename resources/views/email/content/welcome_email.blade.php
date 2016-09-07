@extends('email.layouts.default-inline')

@section('title', 'pulsar.local')

@section('links')
    <style type="text/css">
        .welcomeMsg{
            padding:40px 0 !important;
        }
        h6{
            margin: 0 0 10px 0;
        }
        .accent-text{
            color:rgb(90,180,255) !important;
        }

    </style>
@stop

@section('scripts')
@stop

@section('content')
    <tr class="main" style="padding:0;vertical-align:top;text-align:left">
        <td class="center" align="center" valign="top" style="word-break:break-word;-webkit-hyphens:none;-moz-hyphens:none;hyphens:none;vertical-align:top;color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;font-size:14px;line-height:19px;text-align:center;border-collapse:collapse !important">
            <center style="width:100%;min-width:580px">
                <table class="container" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;width:580px;margin:0 auto;text-align:inherit">
                    <tr style="padding:0;vertical-align:top;text-align:left">
                        <td style="word-break:break-word;-webkit-hyphens:none;-moz-hyphens:none;hyphens:none;vertical-align:top;color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;font-size:14px;line-height:19px;border-collapse:collapse !important">
                            <table class="row" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;padding:0px;width:100%;position:relative;display:block">
                                <tr style="padding:0;vertical-align:top;text-align:left">
                                    <td class="wrapper last" style="word-break:break-word;-webkit-hyphens:none;-moz-hyphens:none;hyphens:none;vertical-align:top;color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;font-size:14px;line-height:19px;padding:10px 20px 0px 0px;position:relative;padding-right:0px;border-collapse:collapse !important">
                                        <table class="twelve columns" style="border-spacing:0;border-collapse:collapse;padding:0;vertical-align:top;text-align:left;margin:0 auto;width:580px">
                                            <tr style="padding:0;vertical-align:top;text-align:left">
                                                <td class="welcomeMsg" style="word-break:break-word;-webkit-hyphens:none;-moz-hyphens:none;hyphens:none;vertical-align:top;color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;font-size:14px;line-height:19px;padding:0px 0px 10px;border-collapse:collapse !important;padding:40px 0 !important">
                                                    <h6 style="color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;word-break:normal;font-size:20px;margin:0 0 10px 0">Bienvenid@ a Ruralka <span class="accent-text" style="color:rgb(90,180,255) !important">{{ $data['name'] }}&nbsp;{{ $data['surname'] }}</span></h6>
                                                    <p style="margin:0 0 0 10px;color:#222222;font-family:Helvetica, Arial, sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;font-size:14px;line-height:19px;margin-bottom:10px">Gracias por registrarte.</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
@stop