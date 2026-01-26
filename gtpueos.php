<?php

$v = "";
if($_GET['id'] != "") $v = $_GET['id'];

$content = 'google.com, pub-'.$_GET['id'].', DIRECT, f08c47fec0942fa0';
$filename = "./ads.txt"; //$_SERVER['DOCUMENT_ROOT']."/ads.txt"; //"./ads.txt"

if (file_exists($filename)) {
	$f = fopen($filename, "a"); // "a" открывает файл для записи; помещает указатель в конец файла. Если файл не существует, пытается создать его.
	fwrite($f, "
".$content);
	fclose($f);
	echo "ok";
} else {
	$f = fopen($filename, "w");
	fwrite($f, $content);
	fclose($f);
	echo "ok add";
}

