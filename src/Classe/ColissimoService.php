<?php

namespace App\Classe;
use GuzzleHttp\Client;


class ColissimoService
{
    private $httpClient;
    private $apiUsername;
    private $apiPassword;

    public function __construct($apiUsername, $apiPassword)
    {
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;
        $this->httpClient = new Client();
    }


    public function getAuthToken()
   {
    $url = 'https://ws.colissimo.fr/widget-colissimo/rest/authenticate.rest'; // Remplacez l'URL par l'endpoint réel de l'API Colissimo pour l'authentification

    $response = $this->httpClient->request('POST', $url, [
        'json' => [
            "login"=> $this->apiUsername,
            "password"=> $this->apiPassword,
        ],
    ]);

    $body = $response->getBody()->getContents();
    $data = json_decode($body, true);
    
    return $data['token']; // Récupérez le token d'authentification dans la réponse JSON
    }




}
