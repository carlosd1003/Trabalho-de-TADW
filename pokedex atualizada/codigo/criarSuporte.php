
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once "conexao.php";
    require_once "function.php";
    ?>
    <form action="salvarSuporte.php" method="post" enctype="multipart/form-data">

        Fazer Reclamacao: <br>
        <input type="text" name="reclamacao" placeholder="Opcional" > <br><br>
        Fazer Sugestao: <br>
        <input type="text" name="sugestao" placeholder="Opcional" > <br><br>
        Informe O Usuário: <br>
        <input type="text" name="idusuario" placeholder="Informe Seu Usuário" id="idusuario"> <br><br>

        <input type="submit" value="Salvar">
    </form> <br>
    <a href="home.php">Voltar</a>

</body>

</html>