<?php

require_once "../conexao.php";
require_once "../function.php";

$nome = "Fogo";

echo "<pre>";
print_r(pesquisarTipos($conexao, $nome));
echo "</pre>";
?>
