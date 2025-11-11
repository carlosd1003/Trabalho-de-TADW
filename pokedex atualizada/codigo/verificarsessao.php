<?php
// NÃO deixar espaço antes desta tag

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['logado']) or $_SESSION['logado'] !== 'sim') {
    header("Location: index.html");
    exit;
}
// Se o valor de $_SESSION['logado'] não for exatamente a string 'sim' (em tipo e conteúdo), redirecione para index.html