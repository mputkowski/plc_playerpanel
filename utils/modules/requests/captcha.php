<?php
if (isset($_GET['captcha'])) {
    $randcap             = rand(100000, 999999);
    $_SESSION["captcha"] = $randcap;
    header('Content-Type: image/gif');
    $img = imagecreate(70, 35);
    $black = imagecolorallocate($img, 0, 0, 0);
	$wh = imagecolorallocate($img, 255, 255, 255);
	$font = "images/other/font.ttf";
	imagecolortransparent($img, $black);
	imagettftext($img, 16, 0, 0, 20, $wh, $font, $randcap);
    imagegif($img, null, 80);
    exit;
}