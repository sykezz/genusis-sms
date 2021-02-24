<?php

namespace Sykez\GenusisSms;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Sykez\GenusisSms\Exceptions\CouldNotSendNotification;

class GenusisGensuiteClient
{
    protected $clientid, $username, $privatekey, $url, $debug_log;

    public function __construct(string $clientid, string $username, string $privatekey, string $url, ?bool $debug_log = false)
    {
        $this->clientid = $clientid;
        $this->username = $username;
        $this->privatekey = $privatekey;
        $this->url = $url;
        $this->debug_log = $debug_log;
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
                        'Message' => 'RM0 ' . $message->content,
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

        try {
            $response = Http::post($this->url . '?Key=' . $hash, $json)->throw();
            $body = $response->json();
            $log = ['status' => $response->status(), 'response' => $response->json(), 'request_json' => $json];

            if (!isset($body['DigitalMedia']) || $body['DigitalMedia'] == '') {
                throw new Exception('blank');
            }

            if (isset($body['DigitalMedia'][0]['Result'])) {
                if ($body['DigitalMedia'][0]['Result'] !== 'success') {
                    throw new Exception($body['DigitalMedia'][0]['Result']);
                }
            } else {
                throw new Exception('Unknown error returned from API: '.json_encode($body));
            }
        } catch (Exception $e) {
            throw CouldNotSendNotification::gensuiteRespondedWithAnError($e, $this->debug_log ? $log : null);
        }

        if ($this->debug_log) {
            Log::info("SMS Sent", $log);
        }

        return $response;
    }
}
