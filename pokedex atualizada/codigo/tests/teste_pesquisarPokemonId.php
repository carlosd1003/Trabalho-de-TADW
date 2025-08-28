<?php

require_once "../conexao.php";
require_once "../function.php";

$idpokemon = 152;

echo "<pre>";
print_r(pesquisarPokemonId($conexao, $idpokemon));
echo "</pre>";
?>