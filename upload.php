<?php
require 'lib/crop.php';

$ds = DIRECTORY_SEPARATOR;  //1

$storeFolder = 'input';   //2

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4

    $targetFile =  $targetPath. $_FILES['file']['name'];  //5

    $sizes = getimagesize($_FILES['file']['tmp_name']);
    $w = $sizes[0];
    $h = $sizes[1];

    croppy($_FILES['file']['tmp_name'],'input/thumbs/'.$_FILES['file']['name'],500,$h*(500/$w));
    move_uploaded_file($tempFile,$targetFile); //6


}
