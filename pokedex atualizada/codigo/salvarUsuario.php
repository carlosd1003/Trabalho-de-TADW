<?php
require_once "./function.php";
require_once "./conexao.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$Tipo = 'C';
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

criarUsuario($conexao, $nome, $email, $senha, $Tipo, $pokemon_fav = NULL, $descricao = NULL);
header("Location:index.html");
