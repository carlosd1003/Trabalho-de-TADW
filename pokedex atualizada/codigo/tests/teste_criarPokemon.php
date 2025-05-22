<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $national = 152;
    $nome = "pikaraio";
    $gen = 1;

    criarPokemon($conexao, $national, $nome, $gen);
?>