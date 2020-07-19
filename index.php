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
