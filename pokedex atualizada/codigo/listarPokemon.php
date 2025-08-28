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
            // Pega a imagem do banco
            $imagemBanco = $pokemon['imagem'];
            
            if (!empty($imagemBanco)) {
                // Usa a imagem do banco (supondo que seja um caminho relativo válido)
                $urlImagem = 'uploads/' . $imagemBanco; // Exemplo: 'uploads/pokemon_123.png'
            } else {
                // Se não tiver imagem no banco, usa a da PokeAPI
                $idImagem = htmlspecialchars($pokemon['idpokemon']);
                $urlImagem = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$idImagem.png";
            }
            
            echo "<div class='card'>";
            echo "<img src='$urlImagem' alt='Imagem do Pokémon'>";
            echo "<h2>" . htmlspecialchars($pokemon['nome']) . "</h2>";
            echo "<p><strong>Dex:</strong> " . htmlspecialchars($pokemon['national']) . "</p>";
            echo "<p><strong>Geração:</strong> " . htmlspecialchars($pokemon['gen']) . "</p>";

            // Exibe os stats do Pokémon atual
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
                    break; // Não precisa procurar mais stats para este Pokémon
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
