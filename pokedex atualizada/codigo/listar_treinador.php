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

    $lista_treinador = listarTreinador($conexao);

    if (count($lista_treinador) == 0) {
        echo "Não existem clientes cadastrados";
    } else {
    ?>
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Nome</td>
                <td>Idade</td>
                <td>Gênero</td>
                <td>Cidade</td>
                <td>Região</td>
                <td>Time Atual</td>
                <td>Data</td>
                <td>Pokemons</td>
                <td colspan="2">Ação</td>
            </tr>
        <?php
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
            echo "<td><a href='deletar_treinador.php?id=$idtreinador'>Excluir</a></td>";
            echo "<td><a href='formtreinador.php?id=$idtreinador'>Editar</a></td>";
            echo "</tr>";
        }
    }
        ?>
        </table>
</body>
</html>