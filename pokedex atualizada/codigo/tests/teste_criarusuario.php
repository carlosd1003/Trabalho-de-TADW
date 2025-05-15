<?php
    require_once "../conexao.php";
    require_once "../funcoes.php";

    $email = "daniel@gmail.com";
    $senha = "123";

    salvarUsuario($conexao, $email, $senha);
?>