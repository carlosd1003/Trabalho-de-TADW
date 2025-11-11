<?php
require_once 'conexao.php';
require_once 'function.php';

// aqui NÃO usamos verificarLogado.php, porque o usuário ainda não existe

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];

criarUsuario($conexao, $nome, $email, $senha, 'C', $pokemon_fav, $descricao);

header("Location: index.html");
exit();
