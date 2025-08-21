<<<<<<< Updated upstream
=======
<?php
// Conexão com o banco de dados
require_once 'conexao.php'; // Arquivo que contém a variável $conexao
require_once 'function.php'; // Arquivo que contém a função listarPokemon()

// Lista os Pokémons
$lista_pokemon = listarPokemon($conexao);

$lista_stats = listarStats($conexao);
?>
>>>>>>> Stashed changes

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pokémons</title>
</head>
<body>
    <h1>Lista de Pokémons</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>National Dex</th>
                <th>Nome</th>
                <th>Geração</th>
                <th>HP</th>
                <th>Attack</th>
                <th>Defense</th>
                <th>Sp. Attack</th>
                <th>Sp. Defense</th>
                <th>Speed</th>
            </tr>
        </thead>

        <tbody>
        <?php
        // Usa htmlspecialchars para converter caracteres especiais em entidades HTML
        // Isso evita que códigos maliciosos (como scripts) sejam executados no navegador,
        // protegendo contra ataques XSS e garantindo que o texto seja exibido corretamente.

            foreach ($lista_pokemon as $pokemon) {
                echo "<tr>";
                    echo "<td>" . htmlspecialchars($pokemon['idpokemon']) . "</td>";
                    echo "<td>" . htmlspecialchars($pokemon['national']) . "</td>";
                    echo "<td>" . htmlspecialchars($pokemon['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($pokemon['gen']) . "</td>";
                

            foreach ($lista_stats as $stats) {
            if ($stats['idpokemon'] == $pokemon['idpokemon']) {
                    echo "<td>" . htmlspecialchars($stats['hp']) . "</td>";
                    echo "<td>" . htmlspecialchars($stats['attack']) . "</td>";
                    echo "<td>" . htmlspecialchars($stats['defense']) . "</td>";
                    echo "<td>" . htmlspecialchars($stats['sp_attack']) . "</td>";
                    echo "<td>" . htmlspecialchars($stats['sp_defense']) . "</td>";
                    echo "<td>" . htmlspecialchars($stats['speed']) . "</td>";
                }
            }

                echo "</tr>";
            }
        ?>


        </tbody>
    </table>
</body>
</html>
