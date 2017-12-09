<?php

if(isset($_FILES['archivo']['name'])){
$fileName = $_FILES["archivo"]["name"]; // The file name
$fileTmpLoc = $_FILES["archivo"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["archivo"]["type"]; // The type of file it is
$fileSize = $_FILES["archivo"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["archivo"]["error"];
}
else{
    if(isset($_FILES['archivo2']['name'])){
    $fileName = $_FILES["archivo2"]["name"]; // The file name
    $fileTmpLoc = $_FILES["archivo2"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["archivo2"]["type"]; // The type of file it is
    $fileSize = $_FILES["archivo2"]["size"]; // File size in bytes
    $fileErrorMsg = $_FILES["archivo2"]["error"];
    }
    else{
        if(isset($_FILES['archivo3']['name'])){
        $fileName = $_FILES["archivo3"]["name"]; // The file name
        $fileTmpLoc = $_FILES["archivo3"]["tmp_name"]; // File in the PHP tmp folder
        $fileType = $_FILES["archivo3"]["type"]; // The type of file it is
        $fileSize = $_FILES["archivo3"]["size"]; // File size in bytes
        $fileErrorMsg = $_FILES["archivo3"]["error"];
        }
    }
}
