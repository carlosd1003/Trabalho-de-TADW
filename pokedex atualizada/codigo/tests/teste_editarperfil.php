<?php
require_once "../conexao.php";
require_once "../function.php";

$nome = "Ciclano";
$pokemon_fav = "oi";
$descricao = "gggg";
$idusuario = 1;
$id = 1;

editarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario, $id);
?>