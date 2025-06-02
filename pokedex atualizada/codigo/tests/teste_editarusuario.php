<?php
require_once "../conexao.php";
require_once "../function.php";

$email= 'andrepedro';
$senha = 2222;
$id = 7;

editarUsuario($conexao,$email,$senha,$id);
?>