<?php
        if (isset($_GET['id'])) {
            // echo "editar";

            require_once "conexao.php";
            require_once "function.php";

            $id = $_GET['id'];

            $treinador = pesquisarTreinador($conexao, $id);
            $nome = $treinador['nome'];
            $pokemon_fav = $treinador['pokemon_fav'];
            $descricao = $treinador['descricao'];
            $idusuario = $treinador['idusuario'];

            $botao = "Atualizar";
        } else {
            // echo "novo";
            $id = 0;
            $nome = "";
            $pokemon_fav = "";
            $descricao = "";
            $idusuario = "";

            $botao = "Cadastrar";
        }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    require_once "conexao.php";
    require_once "function.php";
    ?>
    <h1>Criar Perfil</h1>
    <form action="salvarPerfil.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

        Nome: <br>
        <input type="text" name="nome" placeholder="Informe Seu Nome" value="<?php echo $nome; ?>"> <br><br>
        Seu Pokemon Favorito: <br>
        <input type="text" name="pokemon_fav" placeholder="Informe Seu Pokemon Favorito" value="<?php echo $pokemon_fav; ?>">
        <br><br>
        Descrição (Opcional): <br>
        <input type="text" name="descricao" placeholder="Opcional" value="<?php echo $descricao; ?>"> <br><br>
        Usuario: <br>
        <input type="text" name="idusuario" placeholder="Informe Seu Usuário" value="<?php echo $idusuario; ?>"> <br><br>
            <br>
            <input type="submit" value="<?php echo $botao; ?>">
    </form> <br>
<a href="home.php" class="back-button">Voltar</a>

</body>

</html>