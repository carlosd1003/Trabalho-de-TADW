<?php
require_once "conexao.php";
require_once "function.php";

// Recebe os dados
$national = (int)$_POST['national'];
$nome = $_POST['nome'];
$gen = $_POST['gen'];
$hp = (int)$_POST['hp'];
$attack = (int)$_POST['attack'];
$defense = (int)$_POST['defense'];
$spattack = isset($_POST['spattack']);
$spdefense = isset($_POST['spdefense']);
$speed = (int)$_POST['speed'];
$types = $_POST['types']; // você precisa ver como está salvando os types

// Upload da imagem
$nome_arquivo = $_FILES['imagem']['name'];
$caminho_temporario = $_FILES['imagem']['tmp_name'];
$extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);
$novo_nome = uniqid() . "." . $extensao;
$caminho_destino = "fotos/" . $novo_nome;
move_uploaded_file($caminho_temporario, $caminho_destino);

// Criar o Pokémon
$criado = criarPokemon($conexao, $national, $nome, $gen, $novo_nome);

// Verifica se criou com sucesso
if ($criado) {
    // Recupera o ID do Pokémon recém-criado
    $idpokemon = mysqli_insert_id($conexao);

    // Insere os stats
    criarStats($conexao, $idpokemon, $hp, $attack, $defense, $spattack, $spdefense, $speed);

    // Aqui você pode salvar os types, se tiver uma tabela relacional tipo_pokemon
    // salvarTypes($conexao, $idpokemon, $types); (exemplo se existir)
}

// Redireciona
header("Location: home.php");
exit;
?>
