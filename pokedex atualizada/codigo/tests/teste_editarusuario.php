<?php
require_once "../conexao.php";
require_once "../function.php";

$email= 'joaopedro';
$senha = 2222;
$idusuario = 1;

editarBuild($conexao,$email,$senha,$idusuario);
?>