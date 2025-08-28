<?php
    require_once "conexao.php";
    require_once "function.php";

    $id = $_GET['id'];

    if (deletarTreinador($conexao, $id)) {
        header("Location: listarTreinador.php");
    }
    else {
        header("Location: erro.php");
    }

?>