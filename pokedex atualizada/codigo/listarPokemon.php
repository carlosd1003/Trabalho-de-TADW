<?php
require_once 'conexao.php';
require_once 'function.php';

$lista_pokemon = listarPokemon($conexao);
$lista_stats = listarStats($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Pokédex</h1>
    <div class="card-container">
        <?php
        foreach ($lista_pokemon as $pokemon) {
            $idImagem = htmlspecialchars($pokemon['idpokemon']);
            $urlImagem = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$idImagem.png";

            echo "<div class='card'>";
            echo "<img src='$urlImagem' alt='Imagem do Pokémon'>";
            echo "<h2>" . htmlspecialchars($pokemon['nome']) . "</h2>";
            echo "<p><strong>Dex:</strong> " . htmlspecialchars($pokemon['national']) . "</p>";
            echo "<p><strong>Geração:</strong> " . htmlspecialchars($pokemon['gen']) . "</p>";

            foreach ($lista_stats as $stats) {
                if ($stats['idpokemon'] == $pokemon['idpokemon']) {
                    echo "<div class='stats'>";
                    echo "<p><strong>HP:</strong> " . htmlspecialchars($stats['hp']) . "</p>";
                    echo "<p><strong>Attack:</strong> " . htmlspecialchars($stats['attack']) . "</p>";
                    echo "<p><strong>Defense:</strong> " . htmlspecialchars($stats['defense']) . "</p>";
                    echo "<p><strong>Sp. Attack:</strong> " . htmlspecialchars($stats['sp_attack']) . "</p>";
                    echo "<p><strong>Sp. Defense:</strong> " . htmlspecialchars($stats['sp_defense']) . "</p>";
                    echo "<p><strong>Speed:</strong> " . htmlspecialchars($stats['speed']) . "</p>";
                    echo "</div>";
                    break;
                    //Por que usar "break;" aqui?
                    //se o $lista_stats tiver 500 stats de pokémons diferentes, você não quer percorrer tudo — só quer o primeiro que for igual ao Pokémon atual. Assim que encontrar, não precisa continuar o loop.
                    //porque você só precisa pegar os stats de UM Pokémon específico, aquele que está sendo exibido no momento.


                }
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
