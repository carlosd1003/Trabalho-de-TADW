<?php

require_once "conexao.php";

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    header("Location: index.html");
    exit;
}

// Usando prepared statement para maior segurança
$sql = "SELECT idusuario, senha, Tipo FROM usuario WHERE email = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    // Usuário não encontrado
    header("Location: index.html");
    exit;
}

$linha = mysqli_fetch_assoc($resultado);
$senha_banco = $linha['senha'];
$Tipo = $linha['Tipo'];
$idusuario = $linha['idusuario'];

if (password_verify($senha, $senha_banco)) {
    session_start();
    $_SESSION['logado'] = 'sim';
    $_SESSION['Tipo'] = $Tipo;
    $_SESSION['usuario_idusuario'] = $idusuario;  // <- guardando o id do usuário!
    header("Location: home.php");
    exit;
} else {
    header("Location: index.html");
    exit;
}
?>
