<?php
require_once "conexao.php";

// Pegando os dados
$id = $_GET['id'] ?? 0;

$national = $_POST['national'] ?? '';
$nome = $_POST['nome'] ?? '';
$gen = $_POST['gen'] ?? '';

$tipo1 = $_POST['tipo1'] ?? null;
$tipo2 = $_POST['tipo2'] ?? null;

$hp = $_POST['hp'] ?? 0;
$attack = $_POST['attack'] ?? 0;
$defense = $_POST['defense'] ?? 0;
$sp_attack = $_POST['sp_attack'] ?? 0;
$sp_defense = $_POST['sp_defense'] ?? 0;
$speed = $_POST['speed'] ?? 0;

// Verifica se os campos obrigatórios estão preenchidos
if (empty($national) || empty($nome) || empty($gen) || empty($tipo1)) {
    die("Preencha todos os campos obrigatórios.");
}

if ($id == 0) {
    // INSERT na tabela pokemon
    $sql = "INSERT INTO pokemon (national, nome, gen) VALUES ($national, '$nome', $gen)";
    mysqli_query($conexao, $sql);
    $idpokemon = mysqli_insert_id($conexao);
} else {
    // UPDATE na tabela pokemon
    $sql = "UPDATE pokemon SET national = $national, nome = '$nome', gen = $gen WHERE idpokemon = $id";
    mysqli_query($conexao, $sql);
    $idpokemon = $id;

    // Limpa tipos antigos e stats antigos
    mysqli_query($conexao, "DELETE FROM pokemon_has_types WHERE idpokemon = $idpokemon");
    mysqli_query($conexao, "DELETE FROM stats WHERE idpokemon = $idpokemon");
}

// Inserir tipos
mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ($idpokemon, $tipo1)");
if (!empty($tipo2)) {
    mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ($idpokemon, $tipo2)");
}

// Inserir stats
$sqlStats = "INSERT INTO stats (hp, attack, defense, sp_attack, sp_defense, speed, idpokemon) 
VALUES ($hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $idpokemon)";
mysqli_query($conexao, $sqlStats);

echo "Pokémon salvo com sucesso! <a href='cadastroPokemon.php'>Cadastrar outro</a>";
?>
