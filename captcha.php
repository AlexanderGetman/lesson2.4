<?php
session_start();

$captchaNumber = $_SESSION['captcha'] = rand(1000, 9999);
$captchaBackgrnd = __DIR__ . '\src\background.png';
$font = __DIR__ . '\src\couriernew.ttf';
$image = imagecreatefrompng($captchaBackgrnd);
$textColor = imagecolorexact($image, 0, 0, 0);

imagettftext($image, 85, 0, 250, 250, $textColor, $font, $captchaNumber);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);

