<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $national = 152;
    $nome = "pikachuzin";
    $gen = 1;

    criarPokemon($conexao, $national, $nome, $gen);
?>