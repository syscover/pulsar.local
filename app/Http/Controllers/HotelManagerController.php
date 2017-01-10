<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Syscover\HotelManager\Facades\HotelManager;

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
//        $response = HotelManager::closeTransaction([
//            'lang'          => $request->input('lang'),
//            'checkInDate'   => $request->input('checkInDate'),
//            'checkOutDate'  => $request->input('checkOutDate'),
//            'cantidad'      => 1
//        ]);


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