<?php
header('Content-Type: application/json; charset=utf-8');

require_once './conexao.php'; // abre $conexao (mysqli)

$max = 0;
$sql = "SELECT COALESCE(MAX(national), 0) AS maxId FROM pokemon";
if ($res = mysqli_query($conexao, $sql)) {
    $row = mysqli_fetch_assoc($res);
    if ($row && isset($row['maxId'])) {
        $max = (int)$row['maxId'];
    }
    mysqli_free_result($res);
}

echo json_encode(['maxId' => $max], JSON_UNESCAPED_UNICODE);
