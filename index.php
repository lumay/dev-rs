<?php
include("autoload.php");

use App\SdkFacade;


$sdk = new SdkFacade([
	[
        "name" => "Cours",
        "client_id" => "",
        "client_secret" => ""
    ],
    [
        "name" => "Github",
        "client_id" => "ffce5d872677d68978e1",
        "client_secret" => "df91a68505e116b0b03116391da69bd0411bc93d"
    ],
    [
        "name" => "Facebook",
        "client_id" => "1093203704408257",
        "client_secret" => "e8cae2df6c9aa5e45a26e80edffcfe57"
    ]
]);

if (!isset($_GET["code"])) {
    $links = $sdk->getLinks();
    foreach ($links as $key => $link){
        echo "<a href='".$link."'>".$key."</a><br><br><br>";
    }
} else {
    var_dump($sdk->getUserData());
}
