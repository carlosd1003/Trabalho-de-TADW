<?php

// Inicia a sessão para manter informações do usuário logado
session_start();

// Inclui o arquivo responsável por verificar se o usuário está autenticado.
// Caso não esteja, normalmente redireciona para a página de login.
require_once 'verificarLogado.php';

// Inclui o arquivo de conexão com o banco de dados.
// Aqui é onde a variável $conexao é criada para ser usada nas consultas SQL.
require_once "conexao.php";

// Inclui o arquivo com funções auxiliares, onde está definida a função deletarSugestao_reclamacao().
require_once "function.php";

// Captura o 'id' passado via URL (método GET) que representa a sugestão/reclamação a ser deletada.
$id = $_GET['id'];

// Chama a função que tenta excluir a sugestão/reclamação no banco de dados.
// Essa função recebe a conexão com o banco e o ID do registro a ser apagado.
if (deletarSugestao_reclamacao($conexao, $id)) {
    // Se a exclusão for bem-sucedida, redireciona o usuário para a página de listagem.
    header("Location: listarSuporte.php");
} 
else {
    // Se ocorrer algum erro na exclusão, redireciona o usuário para uma página de erro.
    header("Location: erro.php");
}

?>
