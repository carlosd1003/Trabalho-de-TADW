<?php
session_start();
require_once 'verificarLogado.php';
require_once "conexao.php";
require_once "function.php";

$id = $_GET['id'];
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$genero = $_POST['genero'];
$cidade = $_POST['cidade'];
$regiao = $_POST['regiao'];
$time_atual = $_POST['time_atual'];
$data_cadastro = $_POST['data'];
$idpokemon = $_POST['idpokemon'];

if ($id == 0) {
    criarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon);
} else {
    editarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id);
}
header("Location:listarTreinador.php");
