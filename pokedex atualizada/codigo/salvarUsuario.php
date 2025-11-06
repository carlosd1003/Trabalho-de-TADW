<?php
require_once 'conexao.php';
require_once 'function.php';
require_once 'verificarLogado.php';

$id = $_SESSION['usuario_idusuario'] ?? 0; // pega ID da sessão

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']); // pode estar vazio
$pokemon_fav = trim($_POST['pokemon_fav']);
$descricao = trim($_POST['descricao']);

if ($id > 0) {
    // Edita usuário existente
    editarUsuario($conexao, $id, $nome, $email, $senha, $pokemon_fav, $descricao);
} else {
    // Cria novo usuário
    criarUsuario($conexao, $nome, $email, $senha, 'C', $pokemon_fav, $descricao);
}

header("Location: home.php");
exit();
?>
