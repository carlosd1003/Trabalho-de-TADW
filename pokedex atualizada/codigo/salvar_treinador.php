<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $cidade = $_POST['cidade'];
    $regiao = $_POST['regiao'];
    $time_atual = $_POST['time_atual'];
    $data_cadastro = $_POST['data'];
    $idpokemon = $_POST['pokemon'];

criarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon);
?>