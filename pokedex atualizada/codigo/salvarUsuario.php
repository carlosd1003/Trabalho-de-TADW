<?php
require_once "./function.php";
require_once "./conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];
$Tipo = 'C';

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

criarUsuario($conexao, $email, $senha, $Tipo);
