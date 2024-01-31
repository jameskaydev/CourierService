<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Parcels;
use App\Models\User;
use App\Rules\validateDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\validateParcels;
use Illuminate\Support\Facades\Auth;
use App\Traits\InputValidation;

class DeliveryController extends Controller
{
    use InputValidation;
    public function storeDelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'sender_address' => 'required',
            'delivery_address' => 'required',
            'parcels' => 'required|array',

            'parcels.*.width' => 'required',
            'parcels.*.height' => 'required',
            'parcels.*.length' => 'required',
            'parcels.*.weight' => 'required',


        ],InputValidation::GENERAL());

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $User = User::where('email', $request->post('email'))->first();
        if ($User == '') {
            //We save user data separately to minimize duplication in the database and facilitate additional analytics if needed.
            $User = User::create([
                'name' => $request->post('customer_name'),
                'phone' => $request->post('phone_number'),
                'email' => $request->post('email'),
            ]);
        }

        $sender_address = Addresses::where('type', 'sender')
        ->where('address',$request->post('sender_address'))->first();
        $delivery_address = Addresses::where('type', 'delivery')
        ->where('address',$request->post('delivery_address'))->first();
        //We save user data separately to minimize duplication in the database and suggest addresses to users in future orders.

        if($sender_address == ''){
            $sender_address = Addresses::create([
                'type' => 'sender',
                'user_id' => $User['id'],
                'address' => $request->post('sender_address')
            ]);
        }

        if($delivery_address == ''){
            $delivery_address = Addresses::create([
                'type' => 'delivery',
                'user_id' => $User['id'],
                'address' => $request->post('delivery_address')
            ]);
        }

        //We might have multiple parcels in a delivery.
        foreach($request->post('parcels') as $parcel){
            Parcels::create([
                'user_id' => $User['id'],
                'width' => $parcel['width'],
                'height' => $parcel['height'],
                'length' => $parcel['length'],
                'weight' => $parcel['weight'],
                'delivery_address_id' => $delivery_address['id'],
                'sender_address_id' => $sender_address['id']
            ]);
        }

        return response()->json([
            'success' => 'true',
            'message' => 'saved'
        ]);
    }

    public function delivery(Request $request){
        $validator = Validator::make($request->all(), [
            'parcel_id' => 'required',
            'delivery_method' => new validateDelivery,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $delivery_method_name = $request->post('delivery_method');

        $delivery_method = new $delivery_method_name;

        $shippingController = new ShippingController($delivery_method);
        $shippingController->processShipping($request->post('parcel_id'));
        //Now, to add another delivery method, we just need to create another class that implements the DeliveryMethodInterface. You can add as many delivery methods as you want.
    }


}
