<?php


namespace App;


abstract class AbstractProvider implements ProviderInterface
{

    public function getLink(): string
    {
        $parameters = [
            'client_id' => $this->clientId,
            'state' => "provider-{$this->data['name']}",
            'response_type' => 'code',
            'sdk' => 'php-sdk-7.0',
            'redirect_uri' => "{$this->data['redirect_uri']}",
            'scope' => isset($this->data["scope"]) ? $this->data["scope"] : null
        ];

        return "{$this->accessLink}?".http_build_query($parameters);
    }

    private function getToken(): ?string
    {
        if (isset($_GET["error"])) {
            [
                "error_reason" => $error_reason,
                "error" => $error,
                "error_description" => $error_description
            ] = $_GET;

            echo $error;
            die;
        }

        [
            "code" => $code,
            "state" => $state,
        ] = $_GET;

        $parameters = [
            'client_id' => $this->clientId,
            'redirect_uri' => "{$this->data['redirect_uri']}",
            'client_secret' => $this->clientSecret,
            'code' => $code,
            "grant_type" => "authorization_code"
        ];

        if(in_array($this->data["name"], ["Github"])){
            $result = $this->callback($this->uriAuth, $parameters);
            $string = explode("&", $result, 2)[0];
            $access_token = explode("=", $string)[1];
        }else{
            $surl = "{$this->uriAuth}?".http_build_query($parameters);
            $result = json_decode(file_get_contents($surl), true);
            ['access_token' => $access_token] = $result;
        }

        return $access_token;
    }

    public function callback(string $path, array $body = [])
    {
        if(empty($body)) {
            $token = $this->getToken();
            if(is_null($token)) return null;
            $sapi = $this->uri . $path;
        }else{
            $sapi = $this->uriAuth;
        }

        // Get userdata with access_token
        $rs = curl_init($sapi);

        curl_setopt($rs, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($rs, CURLOPT_HEADER, 0);
        curl_setopt($rs, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/602.3.12 (KHTML, like Gecko) Version/10.0.2 Safari/602.3.12");

        if(!empty($body)){
            curl_setopt($rs, CURLOPT_POST, 1);
            curl_setopt($rs, CURLOPT_POSTFIELDS,$body);
        }else{
            curl_setopt($rs, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer {$token}"
            ]);
        }

        $result = curl_exec($rs);
        curl_close($rs);
        return $result;
    }
}