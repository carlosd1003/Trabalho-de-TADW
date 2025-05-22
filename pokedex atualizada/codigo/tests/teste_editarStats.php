<?php
require_once "../conexao.php";
require_once "../function.php";

$hp = 5;
$attack = 5;
$defense = 5;
$sp_attack = 5;
$sp_defense = 5;
$speed = 5;
$codigo = 152;

editarStats($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $codigo);

?>


