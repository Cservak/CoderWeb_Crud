<?php

$json_file = "config.json";
$json_file_read = file_get_contents($json_file);
$json_decode = json_decode($json_file_read, true);

$host = $json_decode['Host'];
$user = $json_decode['User'];
$password = $json_decode['Password'];
$database = $json_decode['Connection_name'];



try {

    $connect = new mysqli($host, $user, $password, $database);

} catch (Exception $e) {

    die("Hiba a kapcsolat létrehozásakor: " . $e->getMessage());
}

?>