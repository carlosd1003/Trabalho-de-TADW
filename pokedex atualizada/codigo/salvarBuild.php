<?php
session_start();
require_once 'verificarLogado.php';
    require_once "./conexao.php";
    require_once "./function.php";

    $id = $_GET['id'];
    $nome = $_POST['nome'];
    $idpokemon = $_POST['idpokemon'];
    
if ($id == 0) {
criarbuild($conexao, $nome, $idpokemon);
} else {
editarBuild($conexao,$nome,$idpokemon,$id);
}
header("Location:listarBuild.php");
?>