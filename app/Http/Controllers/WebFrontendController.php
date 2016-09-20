<?php namespace App\Http\Controllers;

/**
 * Class WebFrontendController
 * @package App\Http\Controllers
 */

class WebFrontendController extends Controller
{
    public function home()
    {
        return view('www.content.home');
    }

    public function forms()
    {
        return view('www.content.forms');
    }
}