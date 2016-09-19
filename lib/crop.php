<?php
function croppy($src, $dest, $newWidth, $newHeight, $needResize = false, $autoCrop = true, $rgb = array(255,255,255), $quality = 100){

try{
  //**** Подготовка функции к работе (сбор информации, проверка наличия библиотек) ****//
  if (!file_exists($src)) {
    throw new Exception("Файл не найден.");
  }

    $info = getimagesize($src);

    if ($info === false) {
    throw new Exception("Ошибка чтения информации об изображении.");
  }

    $oldWidth = $info[0];
    $oldHeight = $info[1];

  $mime = explode('/', $info['mime']);

  if (($mime[0] != 'image') || ($mime[1] == 'bmp') || ($mime[0] == 'x-windows-bmp')) {
    throw new Exception("Загружаемый файл не является изображением либо имеет уязвимый формат .bmp");
  }

  if ($mime[1] == 'png') {
    $quality = 9;
  }

  $createImageFunction = "imagecreatefrom" . $mime[1];
  $saveImage = "image" . $mime[1];

    if ((!function_exists($createImageFunction)) && (!function_exists($saveImage))) {
    throw new Exception("Функция для обработки данного формата изображения отсутствует в библиотеке.");
  }

  //**** Создание изображения из исходного файла ****//
    $imageFromSource = @$createImageFunction($src);

  //**** Расчет коэффициентов для вырезания изображения ****//
  $widthCoeff = floor($oldWidth/$newWidth);
  $heightCoeff = floor($oldHeight/$newHeight);

  print_r('w: '.$widthCoeff);
  print_r('h: '.$heightCoeff);
  
  $coeff = ($widthCoeff > $heightCoeff) ? $heightCoeff : $widthCoeff;
  //
  // if ($coeff == 0) {
  //   throw new Exception("Размеры вырезаемого изображения больше размеров исходного.");
  // }

  $cropImageWidth = $newWidth*$coeff;
  $cropImageHeight = $newHeight*$coeff;

  //**** Копирование изображения и сохранение результата ****//
  $resultImage = @imagecreatetruecolor($cropImageWidth, $cropImageHeight);
  imagefill($resultImage, 0, 0, imagecolorallocate($resultImage, $rgb[0], $rgb[1], $rgb[2]));

  $copyResult = imagecopy($resultImage, $imageFromSource, 0, 0, ($oldWidth - $cropImageWidth)/2, ($oldHeight - $cropImageHeight)/2, $cropImageWidth, $cropImageHeight);

  if (!@$saveImage($resultImage, $dest, $quality)) {
    throw new Exception("Ошибка при сохранении изображения на диск.");
  }

  @imagedestroy($resultImage);
  @imagedestroy($imageFromSource);

  if ($needResize) {
    Core_Helper::imageResizer($dest, $dest, $newWidth, $newHeight, false, false);
    return true;
  }

  return true;
}
catch (Exception $e) {
  echo $e->getMessage();

  @imagedestroy($resultImage);
  @imagedestroy($imageFromSource);

  return false;
}
}
