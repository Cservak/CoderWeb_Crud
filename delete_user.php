<?php

include "connect_mysql.php";


if (isset($_GET["id"]) && !empty($_GET["id"]))
{
    global $connect;

    $id = $_GET["id"];
    
    $stmt = $connect->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if($stmt)
    {
        header("Location: index.php");
    }
}
