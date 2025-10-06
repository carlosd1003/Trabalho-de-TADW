<?php

// Inicia a sessão PHP, necessária para manter as informações do usuário logado.
session_start();

// Inclui o arquivo que verifica se o usuário está autenticado.
// Caso o usuário não esteja logado, geralmente ele é redirecionado para a página de login.
require_once 'verificarLogado.php';

// Inclui o arquivo responsável pela conexão com o banco de dados.
// Esse arquivo cria a variável $conexao que será usada nas operações com o banco.
require_once "conexao.php";

// Inclui o arquivo com funções auxiliares do sistema, onde está definida a função deletarBuild().
require_once "function.php";

// Captura o parâmetro 'id' enviado pela URL através do método GET.
// Esse ID representa o registro (build) que será excluído no banco de dados.
$id = $_GET['id'];

// Chama a função deletarBuild(), passando a conexão com o banco e o ID do registro a ser excluído.
// A função retorna true se a exclusão for bem-sucedida ou false se houver algum erro.
if (deletarBuild($conexao, $id)) {
    // Se a exclusão ocorrer com sucesso, o usuário é redirecionado para a página de listagem de builds.
    header("Location: listarBuild.php");
} 
else {
    // Caso ocorra um erro na exclusão, o usuário é redirecionado para uma página de erro.
    header("Location: erro.php");
}

?>
