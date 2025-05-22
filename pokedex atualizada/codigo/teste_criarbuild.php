<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $idpokemon = 152;
    $nome = "pikachuzin";
    $id = 1;

    criarbuild($conexao, $idpokemon, $nome, $id);
?>