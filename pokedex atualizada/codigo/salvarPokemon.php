<?php
session_start();
require_once 'verificarLogado.php';
require_once 'conexao.php';
require_once 'function.php';

$usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

if (!$usuario_idusuario) {
    // Usuário não logado, não pode salvar
    die("Você precisa estar logado para salvar um Pokémon.");
}

// Dados básicos
$idpokemon = $_POST['idpokemon'] ?? null;
$national = (int)$_POST['national'];
$nome = $_POST['nome'];
$gen = (int)$_POST['gen'];
$types = $_POST['types'] ?? [];

// Stats
$hp = (int)$_POST['hp'];
$attack = (int)$_POST['attack'];
$defense = (int)$_POST['defense'];
$spattack = (int)$_POST['spattack'];
$spdefense = (int)$_POST['spdefense'];
$speed = (int)$_POST['speed'];

// Função auxiliar para checar dono do Pokémon (assumindo que pegarPokemonPorId retorna campo 'usuario_idusuario')
if ($idpokemon) {
    $pokemon = pegarPokemonPorId($conexao, (int)$idpokemon);
    if (!$pokemon) {
        die("Pokémon não encontrado.");
    }
    if ($pokemon['usuario_idusuario'] != $usuario_idusuario) {
        die("Você não tem permissão para editar este Pokémon.");
    }
}

// Upload de imagem
$novo_nome = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $nome_arquivo = $_FILES['imagem']['name'];
    $caminho_temporario = $_FILES['imagem']['tmp_name'];
    $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($extensao, $extensoes_permitidas)) {
        $novo_nome = uniqid() . "." . $extensao;
        $pasta_destino = "fotos";
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }
        $caminho_destino = $pasta_destino . "/" . $novo_nome;
        if (!move_uploaded_file($caminho_temporario, $caminho_destino)) {
            $novo_nome = null; // falhou no upload
        }
    }
}

if ($idpokemon) {
    // EDITAR Pokémon

    // Se não enviou nova imagem, mantém a antiga (buscar do DB)
    if (!$novo_nome) {
        $sql_img = "SELECT imagem FROM pokemon WHERE idpokemon = ?";
        $stmt_img = mysqli_prepare($conexao, $sql_img);
        mysqli_stmt_bind_param($stmt_img, 'i', $idpokemon);
        mysqli_stmt_execute($stmt_img);
        mysqli_stmt_bind_result($stmt_img, $imagem_atual);
        mysqli_stmt_fetch($stmt_img);
        mysqli_stmt_close($stmt_img);
        $novo_nome = $imagem_atual;
    }

    // Atualiza tabela pokemon
    $sql = "UPDATE pokemon SET national = ?, nome = ?, gen = ?, imagem = ? WHERE idpokemon = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'isssi', $national, $nome, $gen, $novo_nome, $idpokemon);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Atualiza stats
    $ok_stats = editarStats($conexao, $idpokemon, $hp, $attack, $defense, $spattack, $spdefense, $speed);

    // Atualiza types: delete e insert
    deletarTypes($conexao, $idpokemon);
    salvarTypes($conexao, $idpokemon, $types);

} else {
    // CRIAR Pokémon
    // O usuário logado será o dono do Pokémon
    $ok = criarPokemon($conexao, $national, $nome, $gen, $novo_nome, $usuario_idusuario);

    if ($ok) {
        $idpokemon = mysqli_insert_id($conexao);
        criarStats($conexao, $idpokemon, $hp, $attack, $defense, $spattack, $spdefense, $speed);
        salvarTypes($conexao, $idpokemon, $types);
    }
}

// Redireciona para listar ou home
header("Location: home.php");
exit;
