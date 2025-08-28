<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $nome = "ola";
    $idade = 2;
    $genero = "g";
    $cidade = "3";
    $regiao = "goias";
    $time_atual = "pika";
    $data_cadastro = "2020/12/02";
    $idpokemon = 2;
    $id = 1;

editarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id);
?>