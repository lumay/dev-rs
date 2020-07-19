<?php

namespace App;

class ProviderCours extends AbstractProvider
{

    protected $data = [
        "name" => "Cours",
        "redirect_uri" => "http://localhost:8000",
        "uri" => "http://localhost:8000"
    ];

    protected $idClient;
    protected $clientSecret;
    protected $uri = "https://auth-server";
    protected $accessLink = "https://auth-server/auth";
    protected $uriAuth = "https://auth-server/token";

    public function __construct(string $id_client = null, string $client_secret = null)
    {
        $response = $this->callback("/register", [
            "name" => "cours" . rand(0, 100),
            "uri" => $this->data["uri"],
            "redirect_success" => $this->data["redirect_uri"],
            "redirect_error" => $this->data["redirect_uri"],
        ]);

        //On sauvegarde le client id & secret
        if (!is_null($id_client) && !is_null($client_secret)) {
            $this->idClient = $id_client;
            $this->clientSecret = $client_secret;
        } else {
            $this->idClient = $response["id_client"];
            $this->clientSecret = $response["client_secret"];
        }

    }

    public function getUserData()
    {
        return $this->callback("/me");
    }
}
