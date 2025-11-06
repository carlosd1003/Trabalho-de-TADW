<?php
session_start();
require_once 'conexao.php';
require_once 'function.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];

if ($id > 0) {
    // Edita usuário existente
    editarUsuario($conexao, $id, $nome, $email, $senha, $pokemon_fav, $descricao);
} else {
    // Cria novo usuário
    criarUsuario($conexao, $nome, $email, $senha, 'C', $pokemon_fav, $descricao);
}

header("Location: home.php");
exit;
?>
