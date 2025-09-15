<?php
session_start();
require_once 'verificarLogado.php';
?>
<?php
require_once "./conexao.php";
require_once "./function.php";

$reclamacao = $_POST['reclamacao'];
$sugestao = $_POST['sugestao'];
$idusuario = $_POST['idusuario'];

criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario);

header("Location:home.php");