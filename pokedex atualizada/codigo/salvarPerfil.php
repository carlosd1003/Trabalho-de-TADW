<?php
session_start();
require_once 'verificarLogado.php';
require_once "./conexao.php";
require_once "./function.php";

$id = $_GET['id'];
$nome = $_POST['nome'];
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];
$idusuario = $_POST['idusuario'];

if ($id == 0) {
    criarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario);
} else {
    editarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario, $id);
}
header("Location:home.php");

