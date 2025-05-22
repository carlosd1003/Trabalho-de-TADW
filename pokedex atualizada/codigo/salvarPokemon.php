<?php
require_once "conexao.php";

$id = $_GET['id'] ?? 0;

// Dados do formulário
$national = $_POST['national'];
$nome = $_POST['nome'];
$gen = $_POST['gen'];

$tipo1 = $_POST['tipo1'];
$tipo2 = $_POST['tipo2'] ?? null;

$hp = $_POST['hp'];
$attack = $_POST['attack'];
$defense = $_POST['defense'];
$sp_attack = $_POST['sp_attack'];
$sp_defense = $_POST['sp_defense'];
$speed = $_POST['speed'];

// Se for cadastro (id == 0)
if ($id == 0) {
    // Inserir Pokémon
    $sql = "INSERT INTO pokemon (national, nome, gen) VALUES ('$national', '$nome', '$gen')";
    mysqli_query($conexao, $sql);

    // Pega o último ID inserido
    $id = mysqli_insert_id($conexao);

    // Inserir stats
    $sqlStats = "INSERT INTO stats (idpokemon, hp, attack, defense, sp_attack, sp_defense, speed) 
                 VALUES ('$id', '$hp', '$attack', '$defense', '$sp_attack', '$sp_defense', '$speed')";
    mysqli_query($conexao, $sqlStats);

    // Inserir tipos
    if (!empty($tipo1)) {
        mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ('$id', '$tipo1')");
    }
    if (!empty($tipo2)) {
        mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ('$id', '$tipo2')");
    }

} else {
    // Atualizar Pokémon
    $sql = "UPDATE pokemon SET national='$national', nome='$nome', gen='$gen' WHERE idpokemon = $id";
    mysqli_query($conexao, $sql);

    // Verifica se já existe stats
    $sqlCheckStats = "SELECT * FROM stats WHERE idpokemon = $id";
    $resultStats = mysqli_query($conexao, $sqlCheckStats);

    if (mysqli_num_rows($resultStats) > 0) {
        // Atualizar stats
        $sqlStats = "UPDATE stats 
                     SET hp='$hp', attack='$attack', defense='$defense', sp_attack='$sp_attack', sp_defense='$sp_defense', speed='$speed' 
                     WHERE idpokemon = $id";
    } else {
        // Inserir stats
        $sqlStats = "INSERT INTO stats (idpokemon, hp, attack, defense, sp_attack, sp_defense, speed) 
                     VALUES ('$id', '$hp', '$attack', '$defense', '$sp_attack', '$sp_defense', '$speed')";
    }
    mysqli_query($conexao, $sqlStats);

    // Remover tipos antigos
    mysqli_query($conexao, "DELETE FROM pokemon_has_types WHERE idpokemon = $id");

    // Inserir novos tipos
    if (!empty($tipo1)) {
        mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ('$id', '$tipo1')");
    }
    if (!empty($tipo2)) {
        mysqli_query($conexao, "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES ('$id', '$tipo2')");
    }
}

header("Location: listarPokemon.php");
exit;
?>
