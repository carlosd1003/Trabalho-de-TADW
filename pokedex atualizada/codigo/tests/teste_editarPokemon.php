<?php
require_once "../conexao.php";
require_once "../function.php";

$national = "152";
$nome = "pikacu";
$gen = "1";
$codigo = 152;

editarPokemon($conexao, $national, $nome, $gen, $codigo);
?>