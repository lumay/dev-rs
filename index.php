<?php
include("autoload.php");

if (!isset($_GET["code"])) {
    $links = $sdk->getLinks();
    foreach ($links as $key => $link){
        echo "<a href='".$link."'>".$key."</a><br><br><br>";
    }
} else {
    var_dump($sdk->getUserData());
}
