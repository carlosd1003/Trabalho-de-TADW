<?php
require_once "../conexao.php";
require_once "../function.php";

$email= 'joaopedro';
$senha = 2222;
$id = 1;

editarUsuario($conexao,$email,$senha,$id);
?>