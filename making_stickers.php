<?php
list($width, $height) = getimagesize("./stickers/veo.png");

$tmp = imagecreatetruecolor(500, 375);

$tmp_path = "./stickers/s3.png";
$source = imagecreatefrompng("./stickers/veo.png");
imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 
500 , 375 , $width , $height );

imagepng($tmp, $tmp_path, 9);