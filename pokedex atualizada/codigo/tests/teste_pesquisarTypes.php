<?php

require_once "../conexao.php";
require_once "../function.php";

$nome = "Fogo";

echo "<pre>";
print_r(pesquisarTypes($conexao, $nome));
echo "</pre>";
?>
