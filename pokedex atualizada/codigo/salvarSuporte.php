<?php
session_start();
require_once 'verificarLogado.php';
require_once "./conexao.php";
require_once "./function.php";

if (!isset($_SESSION['email'])) {
    die("Erro: usuário não logado.");
}

$email = $_SESSION['email'];


$reclamacao = $_POST['reclamacao'];
$sugestao = $_POST['sugestao'];
$idusuario = $_POST['idusuario'];

criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario);

header("Location:listarSuporte.php");