<?php
// Define que a resposta será no formato JSON e usa codificação UTF-8
header('Content-Type: application/json; charset=utf-8');

// Importa o arquivo de conexão com o banco de dados
// Esse arquivo deve criar a variável $conexao (objeto mysqli)
require_once './conexao.php';

// Inicializa a variável $max com 0 (caso não haja nenhum Pokémon no banco)
$max = 0;

// Cria uma consulta SQL para pegar o maior valor da coluna "national" na tabela "pokemon"
// COALESCE(MAX(national), 0) significa: se não houver nenhum registro, retorna 0
$sql = "SELECT COALESCE(MAX(national), 0) AS maxId FROM pokemon";

// Executa a consulta SQL no banco
if ($res = mysqli_query($conexao, $sql)) {

    // Pega a linha de resultado como um array associativo
    $row = mysqli_fetch_assoc($res);

    // Se a linha existir e o campo 'maxId' estiver definido
    // converte o valor para inteiro e guarda em $max
    if ($row && isset($row['maxId'])) {
        $max = (int)$row['maxId'];
    }

    // Libera a memória usada pelo resultado da consulta
    mysqli_free_result($res);
}

// Retorna um JSON contendo o maior ID encontrado
// Exemplo de saída: {"maxId": 151}
echo json_encode(['maxId' => $max], JSON_UNESCAPED_UNICODE);
