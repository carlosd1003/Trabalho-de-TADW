<?php

session_start();
require_once 'verificarLogado.php';

    require_once "conexao.php";
    require_once "function.php";

    $id = $_GET['id'];

    if (deletarSugestao_reclamacao($conexao, $id)) {
        header("Location: listarSuporte.php");
    }
    else {
        header("Location: erro.php");
    }

?>