<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $email = "ganguedomofo@gmail.com";
    $senha = "123";
    $Tipo = 'C';

    criarUsuario($conexao, $email, $senha, $Tipo);
?>