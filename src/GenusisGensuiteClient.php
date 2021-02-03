<?php

namespace Sykez\GenusisSms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenusisGensuiteClient
{
    protected $clientid, $username, $privatekey, $url;

    public function __construct(string $clientid, string $username, string $privatekey, string $url)
    {
        $this->clientid = $clientid;
        $this->username = $username;
        $this->privatekey = $privatekey.'0';
        $this->url = $url;
    }

    public function send(GenusisSmsMessage $message)
    {
        $json = [
            'DigitalMedia' => [
                'ClientID' => $this->clientid,
                'Username' => $this->username,
                'SEND' => [
                    [
                        'Media' => 'SMS',
                        'Message' => 'RM0 '.$message->content,
                        'MessageType' => 'S',
                        'Priority' => '1',
                        'Destination' => [
                            [
                                'MSISDN' => $message->to,
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $hash = md5(json_encode($json) . $this->privatekey);
        $response = Http::withOptions([
            'debug' => fopen('php://stderr', 'w'),
        ])->post($this->url . '?Key=' .$hash, $json);

        Log::info("SMS Sent", ['response' => $response, 'status' => $response->status(), 'body' => $response->json()]);
        return $response;
    }

}
