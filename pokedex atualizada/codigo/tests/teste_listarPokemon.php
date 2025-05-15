<?php

require_once "../conexao.php";
require_once "../function.php";

echo "<pre>";
print_r(listarPokemon($conexao));
echo "</pre>";
?>