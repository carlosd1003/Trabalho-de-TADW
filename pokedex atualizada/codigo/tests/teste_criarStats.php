<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $pokemon_idpokemon = "152";
    $hp = "50";
     $attack = "50";
     $defense = "50";
     $sp_attack = "50";
     $sp_defense = "50";
     $speed = "50";

    criarStats($conexao, $pokemon_idpokemon, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed);
?>