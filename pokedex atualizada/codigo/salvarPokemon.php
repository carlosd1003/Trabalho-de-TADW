<?php
require_once "conexao.php";
require_once "function.php";

// Recebe os dados do formulário com isset para evitar erros
$national = isset($_POST['national']) ? (int)$_POST['national'] : 0;
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$gen = isset($_POST['gen']) ? (int)$_POST['gen'] : 0;
$hp = isset($_POST['hp']) ? (int)$_POST['hp'] : 0;
$attack = isset($_POST['attack']) ? (int)$_POST['attack'] : 0;
$defense = isset($_POST['defense']) ? (int)$_POST['defense'] : 0;
$spattack = isset($_POST['spattack']) ? (int)$_POST['spattack'] : 0;
$spdefense = isset($_POST['spdefense']) ? (int)$_POST['spdefense'] : 0;
$speed = isset($_POST['speed']) ? (int)$_POST['speed'] : 0;

// Pega o array de tipos
$types = isset($_POST['types']) ? $_POST['types'] : [];

if (nationalExiste($conexao, $national)) {
    // Pode redirecionar para o formulário com um erro, ou exibir mensagem na tela
    die("Erro: Já existe um Pokémon cadastrado com esse National Dex.");
}

// Se não existe, pode criar o Pokémon
criarPokemon($conexao, $national, $nome, $hp, $attack, $defense, $spattack, $spdefense, $speed, $types);

// Redireciona para a home após inserir
header("Location: home.php");
exit;
?>
