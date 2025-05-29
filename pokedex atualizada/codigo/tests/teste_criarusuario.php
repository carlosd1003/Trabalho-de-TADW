<?php
    require_once "../conexao.php";
    require_once "../function.php";

    $email = "daniel@gmail.com";
    $senha = "123";

    criarUsuario($conexao, $email, $senha);
?>