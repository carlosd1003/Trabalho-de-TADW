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

    $treinador = pesquisarTreinador($conexao, $id);
    $nome = $treinador['nome'];
    $idade = $treinador['idade'];
    $genero = $treinador['genero'];
    $cidade = $treinador['cidade'];
    $regiao = $treinador['regiao'];
    $time_atual = $treinador['time_atual'];
    $data_cadastro = $treinador['data_cadastro'];
    $idpokemon = $treinador['idpokemon'];

    $botao = "Atualizar";
} else {
    // echo "novo";
    $id = 0;
    $nome = "";
    $idade = "";
    $genero = "";
    $cidade = "";
    $regiao = "";
    $time_atual = "";
    $data_cadastro = "";
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
</head>

<body>
    <?php
    require_once 'verificarLogado.php';
    require_once "conexao.php";
    require_once "function.php";
    ?>
 <body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 420px;">
        <h1 class="text-center text-danger mb-4">Cadastro De Treinador</h1>
        <form action="salvar_treinador.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" id="formulario-treinador">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Informe Seu Nome" value="<?php echo htmlspecialchars($nome); ?>" required />
            </div>

            <div class="mb-3">
                <label for="idade" class="form-label">Idade:</label>
                <input type="number" id="idade" name="idade" class="form-control" placeholder="Informe Sua Idade" value="<?php echo htmlspecialchars($idade); ?>" min="1" required />
            </div>

            <div class="mb-3">
                <label for="genero" class="form-label">Gênero:</label>
                <input type="text" id="genero" name="genero" class="form-control" placeholder="Informe Seu Gênero" value="<?php echo htmlspecialchars($genero); ?>" />
            </div>

            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade:</label>
                <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Informe Sua Cidade" value="<?php echo htmlspecialchars($cidade); ?>" />
            </div>

            <div class="mb-3">
                <label for="regiao" class="form-label">Região:</label>
                <input type="text" id="regiao" name="regiao" class="form-control" placeholder="Informe Uma Região Escolhida" value="<?php echo htmlspecialchars($regiao); ?>" />
            </div>

            <div class="mb-3">
                <label for="time_atual" class="form-label">Time Atual:</label>
                <input type="text" id="time_atual" name="time_atual" class="form-control" placeholder="Informe Seu Time Desejado" value="<?php echo htmlspecialchars($time_atual); ?>" />
            </div>

            <div class="mb-3">
                <label for="data" class="form-label">Data Cadastro:</label>
                <input type="date" id="data" name="data" class="form-control" value="<?php echo htmlspecialchars($data_cadastro); ?>" />
            </div>

            <div class="mb-3">
                <label for="idpokemon" class="form-label">Selecione Um Pokémon:</label>
                <select id="idpokemon" name="idpokemon" class="form-select" required>
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

            <button type="submit" class="btn btn-danger w-100"><?php echo $botao; ?></button>
        </form>

        <a href="home.php" class="btn btn-outline-secondary mt-3 w-100">Voltar</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>