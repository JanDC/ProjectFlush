<?php

$img=imagecreatefromjpeg('wc1.jpeg');

imagefilter($img, IMG_FILTER_CONTRAST, -20);

$w = imagesx($img)/2;
$h = imagesy($img)/2;

$pixels_brightness=0;
$steps=0;

for($y=0;$y<$h;$y++)
{
	for($x=0;$x<$w;$x++)
	{
		$rgb = imagecolorat($img, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		$pixels_brightness+=0.299 * $r + 0.587 * $g + 0.114 * $b;
		$steps+=1;
		#echo "#".str_repeat("0",2-strlen(dechex($r))).dechex($r).str_repeat("0",2-strlen(dechex($g))).dechex($g).str_repeat("0",2-strlen(dechex($b))).dechex($b)." ";
	}
	#echo "\r\n";
}
imagedestroy($img);

$img_brightness=$pixels_brightness / $steps - 15;
echo "$img_brightness";
?>
