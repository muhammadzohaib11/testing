<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SwaggerController extends Controller
{
    //
    public function login(Request $request){

        $rules = array(
            'email'                 => 'required',
            'password'              => 'required',
        );
        $customMessages            = [
            'email.required'       => 'The Email is required.',
            'password.required'    => 'The Password is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            //email: ahsoka.tano@q.agency
            //password: Kryze4President
            $client             = new \GuzzleHttp\Client();
            $email              = $request->email;
            $password           = $request->password;
            $apiURL             = 'https://symfony-skeleton.q-tests.com/api/v2/token';

            $body['email']      = $email;
            $body['password']   = $password;

            $res                = $client->post($apiURL, [ 'body' => json_encode($body) ]);
            $statusCode         = $res->getStatusCode();
            $result             = $res->getBody();

            $responseBody       = json_decode($result, true);
            $token_key          = $responseBody['token_key'];
            echo 'Token_key =>'. $token_key.'<hr>';
            dd($responseBody);
        }

    }
}
