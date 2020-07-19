<?php
include("autoload.php");

use App\SdkFacade;


$sdk = new SdkFacade([
	[
        "name" => "Cours",
        "client_id" => "",
        "client_secret" => ""
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
