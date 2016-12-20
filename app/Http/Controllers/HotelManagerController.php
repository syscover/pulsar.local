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
        $params = [
            'datos' => json_encode([
                'lang'          => $request->input('lang'),
                'hotelIds'      => explode(',',$request->input('hotelIds')), // You must pass a array with hotel IDs
                'checkInDate'   => $request->input('checkInDate'),
                'checkOutDate'  => $request->input('checkOutDate'),
                'room'          => [
                    'numberRooms'       => $request->input('numberRooms'),
                    'numberAdults'      => $request->input('numberAdults'),
                    'numberChildren'    => $request->input('numberChildren')
                ],
                'user'          => config('hotelManager.user'),
                'pass'          => config('hotelManager.password'),
                'token'         => config('hotelManager.token'),
                'action'        => $request->input('action')
            ])
        ];

        $response = HotelManager::checkAvailability($params);

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }
}