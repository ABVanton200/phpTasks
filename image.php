<?php

  header ("Content-type: image/png");
  
  $WIDTH = 600;
  $HEIGHT = 300; 

  $FONT = './arial.ttf';  
  
  $ctx = imagecreate ($WIDTH, $HEIGHT);
  $red = imagecolorallocate($ctx, 255, 0, 0);
  $blue = imagecolorallocate($ctx, 0, 0, 255);
  $white = imagecolorallocate($ctx, 255, 255, 255);
  
  imagefill($ctx, 0, 0, $white);
  
  $rates = json_decode(file_get_contents('https://kodaktor.ru/j/rates'));
  $wRect = $WIDTH / count($rates);
  
  $names = array_map(function($x) {
	  return $x -> name;
  }, $rates);
  
  $values = array_map(function($x) {
	  return $x -> sell;
  }, $rates);
  
  $max = max($values);
  
  $values = array_map(function($x) use ($max, $HEIGHT) {
	  return ($x / $max) * $HEIGHT;
  }, $values);
  
  array_walk($rates, function($x, $i) use ($wRect, $ctx, $HEIGHT, $red, $blue, $names, $values, $FONT) {
	  $x1 = $wRect * $i;
	  $y1 = $HEIGHT;
	  
	  $x2 = $wRect * ($i + 1) - 15;
	  $y2 = $HEIGHT - $values[$i];
	  
	  imagefilledrectangle($ctx, $x1, $y1, $x2, $y2, $red);
	  
	  $box = imagettfbbox(8, 0, $FONT, $names[$i]);
	  $boxWidth = $box[4] - $box[0];
	  $boxLeft = ($wRect - 15 - $boxWidth) / 2;
	  $boxX = $x1 + $boxLeft;
	  $boxY = $HEIGHT - 15; 
	  imagettftext($ctx, 8, 0, $boxX, $boxY, $blue, $FONT, $names[$i]);
  });
  
  imagepng($ctx);
  imagedestroy($ctx);
  