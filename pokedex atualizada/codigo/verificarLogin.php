<?php
    require_once "conexao.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";

    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 0) {
        header("Location: index.html");
    }
    else {
        $linha = mysqli_fetch_array($resultado);
        $senha_banco = $linha['senha'];
        $Tipo = $linha['Tipo'];

        if (password_verify($senha, $senha_banco)) {
            session_start();
            $_SESSION['logado'] = 'sim';
            $_SESSION['Tipo'] = $Tipo;
            header("Location: home.php");
        }
        else {
            header("Location: index.html");
        }
    }
?>