<?php
        if (isset($_GET['id'])) {
            // echo "editar";

            require_once "conexao.php";
            require_once "function.php";

            $id = $_GET['id'];

            $build = pesquisarBuild($conexao, $id);
            $nome = $build['nome'];
            $idpokemon = $build['idpokemon'];

            $botao = "Atualizar";
        } else {
            // echo "novo";
            $id = 0;
            $nome = "";
            $idpokemon = "";

            $botao = "Cadastrar";
        }
        ?>
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
    <form action="salvarBuild.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

        Nome: <br>
        <input type="text" name="nome" value="<?php echo $nome; ?>"> <br><br>
        Selecione Um Pokemon:
        <select name="idpokemon" id="idpokemon" value="<?php echo $idpokemon; ?>"> <br>
<?php

        $lista_pokemon = listarPokemon($conexao);
            
            foreach ($lista_pokemon as $pokemon) {
                $idpokemon = $pokemon['idpokemon'];
                $nome = $pokemon['nome'];
                
                echo "<option value='$idpokemon'>$nome</option>";
            }
?>

    <input type="submit" value="<?php echo $botao; ?>">
    </form> <br>
    <a href="home.php">Voltar</a>

</body>

</html>