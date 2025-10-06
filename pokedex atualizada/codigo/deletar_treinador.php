<?php

// Inicia a sessão PHP para manter os dados do usuário logado durante a navegação.
session_start();

// Inclui o arquivo responsável por verificar se o usuário está autenticado.
// Caso o usuário não esteja logado, este arquivo normalmente redireciona para a página de login.
require_once 'verificarLogado.php';

// Inclui o arquivo que realiza a conexão com o banco de dados.
// Ele cria a variável $conexao, que será utilizada nas operações SQL.
require_once "conexao.php";

// Inclui o arquivo que contém funções auxiliares do sistema.
// A função deletarTreinador() está definida nesse arquivo.
require_once "function.php";

// Captura o parâmetro 'id' enviado pela URL via método GET.
// Este ID identifica qual treinador será excluído do banco de dados.
$id = $_GET['id'];

// Tenta excluir o treinador do banco de dados chamando a função deletarTreinador().
// A função retorna true se a exclusão for bem-sucedida ou false se ocorrer algum erro.
if (deletarTreinador($conexao, $id)) {
    // Se a exclusão for concluída com sucesso, o usuário é redirecionado para a lista de treinadores.
    header("Location: listarTreinador.php");
} 
else {
    // Caso ocorra algum erro na exclusão, o usuário é redirecionado para uma página de erro.
    header("Location: erro.php");
}

?>
