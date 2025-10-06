<?php
session_start();
require_once 'verificarLogado.php';

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
<style>
    h1{
        color: white;
    }
</style>
<h1>Lista De Builds</h1>
<body>
    <?php
    require_once "conexao.php";
    require_once "function.php";

    $lista_build = listarBuild($conexao);

    if (count($lista_build) == 0) {
        echo "Não existem clientes cadastrados";
    } else {
    ?>
        <table class="table">
            <thead class="table-dark">
                <td>Id</td>
                <td>Nome</td>
                <td>Pokemon</td>
                <td colspan="2">Ação</td>
            </thead>
        <?php
        foreach ($lista_build as $build) {
            $idbuild = $build['idbuild'];
            $nome = $build['nome'];
            $idpokemon = $build['NomeDoPokemon'];
        
        echo "<tr>";
            echo "<td>$idbuild</td>";
            echo "<td>$nome</td>";
            echo "<td>$idpokemon</td>";
            echo "<td><a class='excluir-button' href='deletarBuild.php?id=$idbuild'>Excluir</a></td>";
            echo "<td><a class='editar-button' href='formCriar_build.php?id=$idbuild'>Editar</a></td>";
            echo "</tr>";
        }
    }
        ?>
        </table> <br>
<a href="home.php" class="back-button">Voltar</a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>