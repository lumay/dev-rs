<?php

function read_file($filename)
{
    if (!file_exists($filename)) {
        throw new \Exception($filename . ' not found');
    }
    $data = file($filename);
    return array_map(fn($item) => unserialize($item), $data);
}

function write_file($data, $filename)
{
    $data = array_map(fn($item) => serialize($item), $data);
    return file_put_contents($filename, implode(PHP_EOL, $data));
}