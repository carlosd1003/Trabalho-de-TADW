<?php
session_start();
require_once 'verificarLogado.php';
require_once 'conexao.php';
require_once 'function.php';

if (!isset($_GET['idpokemon'])) {
    echo "ID do Pokémon não informado.";
    exit;
}

$idpokemon = (int)$_GET['idpokemon'];
$usuario_id = $_SESSION['usuario_idusuario'] ?? null;

if (!$usuario_id) {
    echo "Usuário não autenticado.";
    exit;
}

// Verifica se o Pokémon é do usuário logado
$sql = "SELECT * FROM pokemon WHERE idpokemon = ? AND usuario_idusuario = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $idpokemon, $usuario_id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    echo "Você não tem permissão para deletar este Pokémon.";
    exit;
}

// ⚠️ Ordem IMPORTANTE! Primeiro deleta o que depende do Pokémon
deletarTypes($conexao, $idpokemon);   // <- precisa vir antes do deletarPokemon()
deletarStats($conexao, $idpokemon);
deletarBuild($conexao, $idpokemon);   // se existir builds relacionados

// Agora pode deletar o Pokémon em si
deletarPokemon($conexao, $idpokemon);

// Redireciona para a home
header("Location: home.php");
exit;
?>
