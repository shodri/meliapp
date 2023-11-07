<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
trait ConsumesExternalServices
{
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $hasFile = false, $isJson = false)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        if (method_exists($this, 'resolveAuthorization')){
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }


        $bodyType = ($isJson) ? 'json' : 'form_params';


        if ($hasFile) {
            $bodyType = 'multipart';

            $multipart = [];

            foreach($formParams as $name => $contents) {
                $multipart[] = ['name' => $name, 'contents' => $contents];
            }
        }

       // dd($headers, $queryParams);
       try {
            $response = $client->request($method, $requestUrl, [
                'query' => $queryParams,
                $bodyType => $hasFile ? $multipart : $formParams,
                'headers' => $headers,
            ]);
        } catch (ClientException $e) {

            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            Log::error("Error en la solicitud HTTP. Código de estado: {$statusCode}. Mensaje: {$responseBody}");

            $request = $e->getRequest();
            $requestUrl = $request->getUri()->__toString();
            $requestMethod = $request->getMethod();
            $requestHeaders = $request->getHeaders();
            $requestBody = $request->getBody()->getContents();
            Log::error("Solicitud HTTP que generó el error: Método: {$requestMethod}, URL: {$requestUrl}");
            Log::error("Encabezados de la solicitud: " . json_encode($requestHeaders));
            Log::error("Cuerpo de la solicitud: {$requestBody}");
            
        }    

        $response = $response->getBody()->getContents();

        if (method_exists($this, 'decodeResponse')){
            $response = $this->decodeResponse($response);
        }

        // if (method_exists($this, 'checkIfErrorResponse')){
        //     $response = $this->checkIfErrorResponse($response);
        // }
        
        //dd($response);

        return $response;
    }

    public function makePostRequest($method, $requestUrl)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->request($method, $requestUrl);

        $response = $response->getBody()->getContents();

        if (method_exists($this, 'decodeResponse')){
            $response = $this->decodeResponse($response);
        }

        return $response;
    }
}