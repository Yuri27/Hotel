<?php

	session_start();
	$letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZ';
	$caplen = 6;
	$width = 200; 
	$height = 40;
	$font = '1.ttf';
	$fontsize = 30;
	$font_size = 30;   			//Размер шрифта
	$fon = 60;	

	header('Content-type: image/png');

	$img = imagecreatetruecolor($width, $height);
	imagesavealpha($img, true);
	$bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
	imagefill($img, 0, 0, $bg);
	$captcha = '';
	//putenv( 'GDFONTPATH=' . realpath('.') );
	for($i=0;$i < $fon;$i++)			//добавляем на фон буковки
	{
		//случайный символ
		$captcha = $letters[ rand(0, sizeof($letters)-1) ];
		//случайный цвет
		$curcolor = imagecolorallocatealpha( $img, rand(0,255),rand(0,255),rand(0,255),100 );
		//случайный размер
		$size = rand($font_size-4,$font_size+4);
		imagettftext($img,$size,rand(0,45),rand($width*0.1,$width-$width*0.1),rand($height*0.2,$height),$curcolor,$font,$captcha);
	}
	for ($i = 0; $i < $caplen; $i++)
	{
		$captcha = $letters[ rand(0, strlen($letters)-1) ];//добавление символа в капчу
		$x = ($width - 20) / $caplen * $i + 10;
		$x = rand($x, $x+4);
		$y = $height - ( ($height - $fontsize) / 2 );
/* 		$x = ($i+1)*$fontsize + rand(1,5);		//даем каждому символу случайное смещение
		$y = (($height*2)/3) + rand(0,5); */
		$curcolor = imagecolorallocate( $img, rand(0, 100), rand(0, 100), rand(0, 100) );//случайный цвет для символа
		$angle = rand(0, 25);//угол наклона
		$capcha[] = $captcha;  
		imagettftext($img, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha);
	}
	$capcha = implode("",$capcha);
	$_SESSION['captcha'] = $capcha;

	imagepng($img);//вывод капчи
	imagedestroy($img);//освобождение памяти

?>