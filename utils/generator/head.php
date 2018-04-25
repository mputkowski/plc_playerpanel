<?php
$cache = '/var/www/polandcraft_playerpanel/images/cache/faces/';
header("Content-type: image/png");
$gracz = $_GET['player'];
$size  = 128;
if (!is_dir($cache)) {
    mkdir($cache);
}
$cachePath = $cache . DIRECTORY_SEPARATOR . $gracz . '.png';
if (is_file($cachePath) && !isset($_GET['skip'])) {
    include($cachePath);
    exit();
}
$src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/{$gracz}.png");
if (!$src) {
    $src = imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/char.png");
}
$dest = imagecreatetruecolor(8, 8);
imagecopy($dest, $src, 0, 0, 8, 8, 8, 8);
$bg_color = imagecolorat($src, 0, 0);
$no_helm  = true;
for ($i = 1; $i <= 8; $i++) {
    for ($j = 1; $j <= 4; $j++) {
        if (imagecolorat($src, 40 + $i, 7 + $j) != $bg_color) {
            $no_helm = false;
        }
    }
    if (!$no_helm)
        break;
}
if (!$no_helm) {
    imagecopy($dest, $src, 0, -1, 40, 7, 8, 4);
}
$final = imagecreatetruecolor($size, $size);
imagecopyresized($final, $dest, 0, 0, 0, 0, $size, $size, 8, 8);
imagepng($final, $cachePath);
include($cachePath);
imagedestroy($im);
imagedestroy($dest);
imagedestroy($final);
?>