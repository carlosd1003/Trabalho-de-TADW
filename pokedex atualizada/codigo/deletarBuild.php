<?php
    require_once "conexao.php";
    require_once "function.php";

    $id = $_GET['id'];

    if (deletarBuild($conexao, $id)) {
        header("Location: listarBuild.php");
    }
    else {
        header("Location: erro.php");
    }

?>