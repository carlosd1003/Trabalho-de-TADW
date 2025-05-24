<?php

require_once "../conexao.php";
require_once "../function.php";

echo "<pre>";
print_r(listarTypes($conexao));
echo "</pre>";
?>