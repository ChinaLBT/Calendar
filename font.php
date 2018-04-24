<?php
	header("content-type:text/html;charset=utf-8");
	$html = file_get_contents('https://v1.hitokoto.cn/?c=d&encode=text');

/*
	判断文字长度
*/
	if(strlen($html) >= 120 && strlen($html) <= 300){
		echo $html;
	}
	else{
		Header("Location: font.php");
	}
 ?>
