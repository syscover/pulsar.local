<?php namespace App\Http\Controllers;

use Syscover\FacturaDirecta\Facades\FacturaDirecta;

/**
 * Class FacturaDirectaController
 * @package App\Http\Controllers
 */

class FacturaDirectaController extends Controller
{
    public function getClients()
    {
        $response['clients'] = [];
        $apiResponse        = FacturaDirecta::getClients();

        if(isset($apiResponse['client']))
            $response['clients'] = $apiResponse['client'];

        return view('www.content.fd_clients', $response);
    }
}