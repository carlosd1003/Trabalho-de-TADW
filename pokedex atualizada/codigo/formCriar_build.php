<?php
session_start();
require_once 'verificarLogado.php';
?>
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
    <link rel="stylesheet" href="style.css">
    <script src="./jquery-3.7.1.min.js"></script>
    <script src="./jquery.validate.min.js"></script>
    <script>
        // programar a validação do formulário
        $('document').ready(function () {
            $('#formulario').validate({
                rules: {
                    nome: {
                        required: true,
                        minlength: 3,
                    },
                },
                messages: {
                    nome: {
                        required: "Esse campo não pode ser vazio",
                        minlength: "Tamanho mínimo de 3 símbolos"
                    },
                }
            })
        })
    </script>
</head>

<body>
    <?php
    require_once "conexao.php";
    require_once "function.php";
    ?>
    <h1>Cadastro De Builds</h1>
    <form id="formulario" action="salvarBuild.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

        Nome: <br>
        <input type="text" name="nome" id="nome" value="<?php echo $nome; ?>"> <br><br>
        Selecione Um Pokemon:
        <select name="idpokemon" id="idpokemon">
            <?php
            $lista_pokemon = listarPokemon($conexao);

            foreach ($lista_pokemon as $pokemon) {
                $id = $pokemon['idpokemon'];
                $nome_pokemon = $pokemon['nome'];

                // Verifica se o Pokémon atual é o selecionado
                $selected = ($id == $idpokemon) ? "selected" : "";

                echo "<option value='$id' $selected>$nome_pokemon</option>";
            }
            ?>

            <input type="submit" class="cadastrar-button" value="<?php echo $botao; ?>">
    </form>
<a href="home.php" class="back-button">Voltar</a>

</body>

</html>