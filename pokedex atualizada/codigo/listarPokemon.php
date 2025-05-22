<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pokémon</title>
</head>

<body>
    <h1>Lista de Pokémon</h1>

    <?php
    require_once "conexao.php";
    require_once "function.php"; // Corrija para o nome certo do seu arquivo de funções

    $lista_pokemon = listarPokemon($conexao);

    if (count($lista_pokemon) == 0) {
        echo "Não existem pokémons cadastrados.";
    } else {
    ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>National</th>
                <th>Nome</th>
                <th>Geração</th>
                <th>Tipos</th>
                <th>Ações</th>
            </tr>

            <?php
            foreach ($lista_pokemon as $pokemon) {
                $idpokemon = $pokemon['idpokemon'];
                $national = $pokemon['national'];
                $nome = $pokemon['nome'];
                $gen = $pokemon['gen'];
                $tipos = $pokemon['tipos'];

                echo "<tr>";
                echo "<td>$idpokemon</td>";
                echo "<td>$national</td>";
                echo "<td>$nome</td>";
                echo "<td>$gen</td>";
                echo "<td>$tipos</td>";
                echo "<td>
                        <a href='formPokemon.php?id=$idpokemon'>Editar</a> | 
                        <a href='deletarPokemon.php?id=$idpokemon' onclick=\"return confirm('Tem certeza que deseja excluir?');\">Excluir</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php
    }
    ?>

</body>

</html>
