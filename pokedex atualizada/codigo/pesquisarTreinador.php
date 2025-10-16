<?php
session_start();
require_once 'verificarLogado.php'; // Seu script de verificação de login
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Treinadores</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        h1 {
            color: white;
        }
    </style>
</head>

<body>
    <!-- Formulário de Pesquisa -->
    <form action="pesquisarTreinador.php">
        <div class="input-group mb-3">
            <input class="form-control" placeholder="Pesquisar Treinador" type="text" name="valor">
            <input class="btn btn-primary" type="submit" value="pesquisar">
        </div>
    </form>

    <div>

        <?php
        // Verifica se existe um valor de pesquisa
        if (isset($_GET["valor"]) && !empty($_GET["valor"])) {
            $valor = $_GET["valor"];

            require_once 'conexao.php';
            require_once 'function.php';

            $treinadores = pesquisarTreinador($conexao, $valor);

            if (!isset($treinadores) || !is_array($treinadores) || count($treinadores) == 0) {
                echo "<p>Nenhum treinador encontrado</p>";
            } else {
                echo "<table class='table'>";
                echo "<thead class='table-dark'>
            <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>Gênero</th>
                        <th>Cidade</th>
                        <th>Região</th>
                        <th>Time Atual</th>
                        <th>Data de Cadastro</th>
                        <th>Pokémons</th>
                        <th colspan='2'>Ação</th>
                    </tr>
                  </thead>
                  <tbody>";

                foreach ($treinadores as $treinador) {
                    echo "<tr>";
                    echo "<td>" . $treinador["idtreinador"] . "</td>";
                    echo "<td>" . $treinador["nome"] . "</td>";
                    echo "<td>" . $treinador["idade"] . "</td>";
                    echo "<td>" . $treinador["genero"] . "</td>";
                    echo "<td>" . $treinador["cidade"] . "</td>";
                    echo "<td>" . $treinador["regiao"] . "</td>";
                    echo "<td>" . $treinador["time_atual"] . "</td>";
                    echo "<td>" . $treinador["data_cadastro"] . "</td>";
                    echo "<td>" . $treinador['idpokemon'] . "</td>";
                    echo "<td><a class='btn btn-danger' href='deletar_treinador.php?id={$treinador['idtreinador']}'>Excluir</a></td>";
                    echo "<td><a class='btn btn-warning' href='formtreinador.php?id={$treinador['idtreinador']}'>Editar</a></td>";
                    echo "</tr>";
                    // echo "</tr>";
                }
                echo "</tbody>";
            }
        }
        ?>

    </div>
    
    <!-- <a href="home.php" class="back-button">Voltar</a> -->
    <a href="home.php">Voltar</a>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script> -->
</body>

</html>