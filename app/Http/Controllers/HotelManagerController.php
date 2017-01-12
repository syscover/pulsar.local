<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Syscover\HotelManager\Facades\HotelManager;
use Syscover\Pulsar\Models\Country;

/**
 * Class HotelManagerController
 * @package App\Http\Controllers
 */

class HotelManagerController extends Controller
{
    public function hotelManager()
    {
        return view('www.content.hotel_manager');
    }

    public function checkAvailability(Request $request)
    {
        $response = HotelManager::checkAvailability([
            'lang'              => $request->input('lang'),
            'hotelIds'          => explode(',', $request->input('hotelIds')), // You must pass a array with hotel IDs
            'checkInDate'       => $request->input('checkInDate'),
            'checkOutDate'      => $request->input('checkOutDate'),
            'numberRooms'       => $request->input('numberRooms'),
            'numberAdults'      => $request->input('numberAdults'),
            'numberChildren'    => $request->input('numberChildren')
        ]);

        // add parameters for view
        $response['checkInDate']    = $request->input('checkInDate');
        $response['checkOutDate']   = $request->input('checkOutDate');
        $response['numberRooms']    = $request->input('numberRooms');
        $response['numberAdults']   = $request->input('numberAdults');
        $response['numberChildren'] = $request->input('numberChildren');

        if($request->input('type') === 'json')
        {
            return response(json_encode($response), 200)
                ->header('Content-Type', 'application/json');
        }
        else
        {
            return view('www.content.hotel_manager_view_availability', $response);
        }
    }

    public function openTransaction(Request $request)
    {
        $response = HotelManager::openTransaction([
            'roomId'        => $request->input('roomId'),
            'checkInDate'   => $request->input('checkInDate'),
            'checkOutDate'  => $request->input('checkOutDate'),
            'numberRooms'   => $request->input('numberRooms')
        ]);

        // add parameters for view
        $response['checkInDate']    = $request->input('checkInDate');
        $response['checkOutDate']   = $request->input('checkOutDate');
        $response['numberRooms']    = $request->input('numberRooms');
        $response['numberAdults']   = $request->input('numberAdults');
        $response['numberChildren'] = $request->input('numberChildren');

        $response['countries']      = Country::builder()->where('lang_id_002', user_lang())->get();

        $response['docTypes']       = array_map(function($object){
            $object->name = trans($object->name);
            return $object;
        }, config('hotelManager.docTypes'));

        $response['paymentMethods']       = array_map(function($object){
            $object->name = trans($object->name);
            return $object;
        }, config('hotelManager.paymentMethods'));


        if($request->input('type') === 'json')
        {
            return response($response, 200)
                ->header('Content-Type', 'application/json');
        }
        else
        {
            return view('www.content.hotel_manager_transaction', $response);
        }
    }

    public function closeTransaction(Request $request)
    {
        $response = HotelManager::closeTransaction([
            'lang'                      => $request->input('lang'),
            'checkInDate'               => $request->input('checkInDate'),
            'checkOutDate'              => $request->input('checkOutDate'),
            'checkInHour'               => $request->input('checkInHour'),
            'checkInMinute'             => $request->input('checkInMinute'),
            'numberRooms'               => $request->input('numberRooms'),
            'numberAdults'              => $request->input('numberAdults'),
            'numberChildren'            => $request->input('numberChildren'),
            'observations'              => $request->input('observations'),
            'name'                      => $request->input('name'),
            'surname'                   => $request->input('surname'),
            'phone'                     => $request->input('phone'),
            'email'                     => $request->input('email'),
            'country'                   => $request->input('country'),
            'docType'                   => $request->input('docType'),
            'docNumber'                 => $request->input('docNumber'),
            'paymentMethod'             => $request->input('paymentMethod'),
            'creditCardHolder'          => $request->input('creditCardHolder'),
            'creditCardNumber'          => $request->input('creditCardNumber'),
            'creditCardDateExpiry'      => $request->input('creditCardDateExpiry'),
            'cvv'                       => $request->input('cvv'),
            'transactionId'             => $request->input('transactionId'),
        ]);


        if($request->input('type') === 'json')
        {
            return response($response, 200)
                ->header('Content-Type', 'application/json');
        }
        else
        {
            return json_decode($response);
        }

    }
}