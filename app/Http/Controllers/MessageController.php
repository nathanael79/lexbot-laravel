<?php

namespace App\Http\Controllers;

use Aws\Credentials\Credentials;
use Aws\LexRuntimeService\LexRuntimeServiceClient;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function postToBot(Request $request){
        $inputText = $request->inputText;
        $userId = $request->userId;
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        $args = [
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => "latest",
            'debug' => env('AWS_DEBUG'),
            'credentials' => $credentials
        ];

        $lexClient = new LexRuntimeServiceClient($args);
        $result = $lexClient->postText([
            'botAlias' => 'GalaxyCarBot',
            'botName' => 'BookTrip',
            'inputText' => $inputText,
            'userId' => $userId
        ]);

//        return $result->get;
        return $result->get('message');
    }
}
