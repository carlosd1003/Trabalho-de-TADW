<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Usuario</title>
    <link rel="stylesheet" href="style.css">
</head>

<body id="page-body">
    <div id="container">
        <h1 id="page-title">Cadastro De Usuario</h1>
        <form id="register-form" action="salvarUsuario.php" method="post">
            <label for="email" id="label-email">E-mail:</label>
            <input type="email" id="email" name="email" ...>

            <label for="senha" id="label-senha">Senha:</label>
            <input type="password" id="senha" name="senha" ...>

            <input type="submit" id="cadastrar-button" value="Cadastrar">
        </form>

        <a href="index.html" id="back-button">Voltar</a>
    </div>
</body>



</html>
