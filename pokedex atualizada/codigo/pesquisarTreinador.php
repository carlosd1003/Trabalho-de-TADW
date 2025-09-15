<?php
session_start();
require_once 'verificarLogado.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Treinadores</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <!-- Formulário de Pesquisa -->
    <form action="pesquisarTreinador.php" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Pesquisar Treinador" name="valor" value="<?php echo isset($_GET['valor']) ? $_GET['valor'] : ''; ?>">
            <button class="btn btn-primary" type="submit">Pesquisar</button>
        </div>
    </form>

    <h1>Lista de Treinadores</h1>

    <?php
    require_once "conexao.php";
    require_once "function.php";

    $lista_treinador = listarTreinador($conexao);

    if (count($lista_treinador) == 0) {
        echo "Não existem clientes cadastrados";


    // Verifica se existe um valor de pesquisa
    if (isset($_GET['valor']) && !empty($_GET['valor'])) {
        $valor = $_GET['valor'];
        $sql = "SELECT * FROM treinador WHERE nome LIKE '%$valor%'";
        $resultados = mysqli_query($conexao, $sql);

        if (mysqli_num_rows($resultados) == 0) {
            echo "Não foram encontrados treinadores com esse nome.";
        } else {
            // Exibindo a tabela de resultados da pesquisa
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
        foreach ($lista_treinador as $treinador) {
            $idtreinador = $treinador['idtreinador'];
            $nome = $treinador['nome'];
            $idade = $treinador['idade'];
            $genero = $treinador['genero'];
            $cidade = $treinador['cidade'];
            $regiao = $treinador['regiao'];
            $time_atual = $treinador['time_atual'];
            $data_cadastro = $treinador['data_cadastro'];
            $idpokemon = $treinador['pokemon_nome'];

            echo "<tr>";
            echo "<td>$idtreinador</td>";
            echo "<td>$nome</td>";
            echo "<td>$idade</td>";
            echo "<td>$genero</td>";
            echo "<td>$cidade</td>";
            echo "<td>$regiao</td>";
            echo "<td>$time_atual</td>";
            echo "<td>$data_cadastro</td>";
            echo "<td>$idpokemon</td>";
            echo "<td><a class='excluir-button' href='deletar_treinador.php?id=$idtreinador'>Excluir</a></td>";
            echo "<td><a class='editar-button' href='formtreinador.php?id=$idtreinador'>Editar</a></td>";
            echo "</tr>";
            }
            echo "</tbody></table>";
        }
    }
    } else {
        // Se não houver pesquisa, exibe a lista completa de treinadores
        $lista_treinador = listarTreinador($conexao);

        if (count($lista_treinador) == 0) {
            echo "Não existem treinadores cadastrados.";
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

            // Exibe a lista completa de treinadores
            foreach ($lista_treinador as $treinador) {
                echo "<tr>";
                echo "<td>{$treinador['idtreinador']}</td>";
                echo "<td>{$treinador['nome']}</td>";
                echo "<td>{$treinador['idade']}</td>";
                echo "<td>{$treinador['genero']}</td>";
                echo "<td>{$treinador['cidade']}</td>";
                echo "<td>{$treinador['regiao']}</td>";
                echo "<td>{$treinador['time_atual']}</td>";
                echo "<td>{$treinador['data_cadastro']}</td>";
                echo "<td>{$treinador['pokemon_nome']}</td>";
                echo "<td><a class='btn btn-danger' href='deletar_treinador.php?id={$treinador['idtreinador']}'>Excluir</a></td>";
                echo "<td><a class='btn btn-warning' href='formtreinador.php?id={$treinador['idtreinador']}'>Editar</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
    }
    ?>

    <br>
    <a href="home.php" class="btn btn-secondary">Voltar</a>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>
