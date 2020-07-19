<?php

function autoloader($className)
{
    $class = __DIR__. "/".$className.".php";
    if(file_exists($class)){
        include $class;
    }
}

// charge la fonction d'autoloader
spl_autoload_register('autoloader');
