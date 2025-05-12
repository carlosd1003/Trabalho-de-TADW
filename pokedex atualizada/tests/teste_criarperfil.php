<?php
    require_once "../conexao.php";
    require_once "../funcoes.php";

    $nome = "oi";
    $pokemon_fav = "ola";
    $descricao = "gg";
    $idusuario = "2";

    salvarVenda($conexao,$nome, $pokemon_fav, $descricao, $idusuario);
?>