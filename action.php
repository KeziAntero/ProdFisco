<?php
session_start();
include 'Prod.php';
$prod = new Prod();
if ($_GET['action'] == 'delete_prod' && $_GET['id']) {
    $prod->deleteProd($_GET['id']);
    $jsonResponse = array(
        "status" => 1
    );
    echo json_encode($jsonResponse);
}
if ($_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location:index.php");
}
