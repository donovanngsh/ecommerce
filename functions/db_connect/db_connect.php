<?php
$path = realpath(__DIR__ . '/..');
include_once $path . '/psl-config.php';
 
//New connection
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* check connection */
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

ob_start();
