<?php

require_once "../conexao.php";
require_once "../function.php";

$idusuario = 2;

echo "<pre>";
print_r(pesquisarSugestao_reclamacao($conexao, $idusuario));
echo "</pre>";
?>