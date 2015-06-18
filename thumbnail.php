<?php

$id = $_GET['id'];
$name = $_GET['filename'];

$filePath = $_SERVER["DOCUMENT_ROOT"] . "/nogollas/nogollas-f3/UploadedFiles/";

$type = 'image/jpeg';
header('Content-Type:'.$type);
header('Content-Length: ' . filesize($filepath.$name));
readfile($filepath.$name);

?>