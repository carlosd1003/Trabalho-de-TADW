<?php
require_once "./conexao.php";
require_once "./function.php";

$id = $_GET['id'];
$reclamacao = $_POST['nome'];
$pokemon_fav = $_POST['pokemon_fav'];
$descricao = $_POST['descricao'];
$idusuario = $_POST['idusuario'];

if ($id == 0) {
    criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario)
}
header("Location:home.php");