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

    $lista_build = listarBuild($conexao);

    if (count($lista_build) == 0) {
        echo "Não existem clientes cadastrados";
    } else {
    ?>
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Nome</td>
                <td>Pokemon</td>
                <td colspan="2">Ação</td>
            </tr>
        <?php
        foreach ($lista_build as $build) {
            $idbuild = $build['idbuild'];
            $nome = $build['nome'];
            $idpokemon = $build['NomeDoPokemon'];
        
        echo "<tr>";
            echo "<td>$idbuild</td>";
            echo "<td>$nome</td>";
            echo "<td>$idpokemon</td>";
            echo "<td><a href='deletarBuild.php?id=$idbuild'>Excluir</a></td>";
            echo "<td><a href='formCriar_build.php?id=$idbuild'>Editar</a></td>";
            echo "</tr>";
        }
    }
        ?>
        </table> <br>
<a href="home.php" class="back-button">Voltar</a>
</body>

</html>