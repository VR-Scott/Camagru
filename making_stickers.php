<?php
$source = imagecreatefrompng("./stickers/dnd_beyond.png");

$tmp = imagecreatetruecolor(500, 375);
imagealphablending($tmp, false);
imagesavealpha($tmp, true);
$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
imagefilledrectangle($tmp, 0, 0, 500, 375, $transparent);
list($width, $height) = getimagesize("./stickers/dnd_beyond.png");
$tmp_path = "./stickers/s1.png";
imagecopyresampled($tmp , $source , 0, 0, 0 , 0, 
500 , 375 , $width , $height );

imagepng($tmp, $tmp_path, 9);