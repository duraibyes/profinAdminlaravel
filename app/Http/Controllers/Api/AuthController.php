<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function sendOTP( Request $request ) {
        $mobile_no = $request->mobile_no;
        return response()->json( [ 'otp' => '0000', 'mobile_no ' => $mobile_no ] );

    }

    public function submitOtp( Request $request ) {

        $mobile = $request->mobile_no;
        $otp = $request->otp;
        $oldOtp = '0000';

        $user = User::where( 'mobile_no', $mobile )->first();
        if ( $otp === $oldOtp ) {
            if ( !$user ) {
                $insertData = [
                    'mobile_no' => $mobile,
                    'name' => 'Guest',
                    'password' => Hash::make( $mobile ),
                ];
                $user = User::create( $insertData );
                $token =  bin2hex( openssl_random_pseudo_bytes( 30 ) );
                $user->api_token = $token;
                $user->save();

            }
            $success[ 'token' ] = $user->api_token;
            $success[ 'user' ] =  $user;
            $success[ 'message' ] = 'Otp Verified Success';
            $success[ 'error' ] = '0';
        } else {
            $success[ 'message' ] = 'Otp is not valid';
            $success[ 'error' ] = '1';
        }

        return response()->json( $success );
    }

    public function test( Request $request ) {
        return response()->json( [ 'otp' => '0000' ] );
    }
}
