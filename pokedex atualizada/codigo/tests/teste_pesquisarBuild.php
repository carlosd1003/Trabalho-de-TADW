<?php

require_once "../conexao.php";
require_once "../function.php";

$idbuild = 2;

echo "<pre>";
print_r(pesquisarBuild($conexao, $idbuild));
echo "</pre>";
?>