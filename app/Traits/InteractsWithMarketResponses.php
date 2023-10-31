<?php

namespace App\Traits;

trait InteractsWithMarketResponses
{

    public function decodeResponse($response)
    {
        $decodedResponse = json_decode($response);
       // dd($response, $decodedResponse->data);

        return $decodedResponse->data ?? $decodedResponse;
    }

    public function checkIfErrorResponse($response)
    {
        if(isset($response->error)) {
            throw new \Exception("Something failed : {$response->error}");
        }
    }


}