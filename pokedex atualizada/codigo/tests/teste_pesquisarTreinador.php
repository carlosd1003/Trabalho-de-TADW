<?php

require_once "../conexao.php";
require_once "../function.php";

$idtreinador = 40;

echo "<pre>";
print_r(pesquisarTreinador($conexao, $idtreinador));
echo "</pre>";
?>