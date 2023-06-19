<?php
// Define o header como sendo de imagem
header("Content-type: image/jpg");
 
// Cria a imagem a partir de uma imagem jpeg
$i = imagecreatefromjpeg("iconbackground.jpg");
 
// Defini��es
$preto = imagecolorallocate($i, 0,0,0);
$branco = imagecolorallocate($i, 255,255,255);

$texto = "OC";
$fonte = "fonts/caslonishfraxx.ttf";

// Escreve na imagem
imagettftext($i, 25, 0, 4,40,$branco,$fonte,$texto);
 
// Gera a imagem na tela
imagejpeg($i);
 
// Destroi a imagem para liberar mem�ria
imagedestroy($i);
?>