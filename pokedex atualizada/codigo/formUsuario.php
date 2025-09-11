<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Cadastro De Usuario</h1>
    <form action="salvarUsuario.php" method="post">

        E-mail: <br>
        <input type="text" name="email"> <br><br>
        Senha: <br>
        <input type="text" name="senha"> <br><br>

        <input type="submit" class="cadastrar-button" value="Cadastrar">
        
    </form>
    <a href="index.html" class="back-button">Voltar</a>
</body>

</html>