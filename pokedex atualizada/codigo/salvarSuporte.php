<?php
session_start();
require_once 'verificarLogado.php';
require_once "./conexao.php";
require_once "./function.php";

$idusuario = $_POST['idusuario'];
$email = $_POST['email'] ?? null;  // se não existir, vira null
$reclamacao = $_POST['reclamacao'] ?? '';
$sugestao = $_POST['sugestao'] ?? '';

criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario);

header("Location:listarSuporte.php");