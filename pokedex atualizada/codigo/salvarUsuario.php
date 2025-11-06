<?php
session_start();
require_once 'conexao.php';
require_once 'function.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$Tipo = 'C';
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];

if ($id == 0) {
    // Cria novo usuário
    criarUsuario($conexao, $id, $nome, $email, $senha, $Tipo, $pokemon_fav, $descricao);
} else {
    // Edita usuário existente
    editarUsuario($conexao, $nome, $email, $senha, $pokemon_fav, $descricao);
}

header("Location: home.php");
exit;
?>
