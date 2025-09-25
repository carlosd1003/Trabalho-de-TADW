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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 400px;">
        <h1 class="mb-4 text-center text-danger">Cadastro De Builds</h1>
        <form id="formulario" action="salvarBuild.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required minlength="3" />
            </div>
            <div class="mb-3">
                <label for="idpokemon" class="form-label">Selecione Um Pokemon:</label>
                <select name="idpokemon" id="idpokemon" class="form-select" required>
                    <?php
                    $lista_pokemon = listarPokemon($conexao);

                    foreach ($lista_pokemon as $pokemon) {
                        $pokeId = $pokemon['idpokemon'];
                        $nome_pokemon = $pokemon['nome'];
                        $selected = ($pokeId == $idpokemon) ? "selected" : "";
                        echo "<option value='$pokeId' $selected>$nome_pokemon</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100"><?php echo $botao; ?></button>
        </form>
        <a href="home.php" class="btn btn-outline-secondary mt-3 w-100">Voltar</a>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>