<?php
require_once 'conexao.php';
require_once 'function.php';
require_once 'verificarLogado.php'; // exige login

$id = $_SESSION['usuario_idusuario'] ?? 0;

if ($id > 0) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $pokemon_fav = $_POST['pokemon_fav'];
    $descricao = $_POST['descricao'];

    editarUsuario($conexao, $id, $nome, $email, $senha, $pokemon_fav, $descricao);
    header("Location: home.php");
    exit();
} else {
    // Usuário não logado não pode editar
    header("Location: index.html");
    exit();
}
