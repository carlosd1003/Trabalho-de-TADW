<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $nome = "oi";
    $idade = 1;
    $genero = "gg";
    $cidade = "1";
    $regiao = "flamengo";
    $time_atual = "pikachu";
    $data_cadastro = "2020/12/02";
    $idpokemon = 1;

criarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon);
?>