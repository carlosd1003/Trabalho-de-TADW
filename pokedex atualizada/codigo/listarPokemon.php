
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Pokémons</title>
</head>
<body>
    <h2>Pokémons Cadastrados</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Geração</th>
            <th>Tipos</th>
            <th>HP</th>
            <th>Ataque</th>
            <th>Defesa</th>
            <th>Sp. Atk</th>
            <th>Sp. Def</th>
            <th>Speed</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { 
            // Buscar os tipos do Pokémon atual
            $idpokemon = $row['idpokemon'];
            $sql_tipos = "SELECT t.nome FROM pokemon_has_types pt
                          JOIN types t ON pt.idtypes = t.idtypes
                          WHERE pt.idpokemon = $idpokemon";
            $tipos_result = mysqli_query($conexao, $sql_tipos);

            $tipos = [];
            while ($tipo = mysqli_fetch_assoc($tipos_result)) {
                $tipos[] = $tipo['nome'];
            }
            $tipos_str = implode(" / ", $tipos);
        ?>
        <tr>
            <td><?= $row['national'] ?></td>
            <td><?= $row['nome_pokemon'] ?></td>
            <td><?= $row['gen'] ?></td>
            <td><?= $tipos_str ?></td>
            <td><?= $row['hp'] ?></td>
            <td><?= $row['attack'] ?></td>
            <td><?= $row['defense'] ?></td>
            <td><?= $row['sp_attack'] ?></td>
            <td><?= $row['sp_defense'] ?></td>
            <td><?= $row['speed'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php mysqli_close($conexao); ?>
