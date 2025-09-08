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
            $types = buscarTypesDoPokemon($conexao, $pokemon['idpokemon']); // <- Aqui dentro
            
            // Pega a imagem do banco
            $imagemBanco = $pokemon['imagem'];
            
         if (!empty($imagemBanco)) {
            $urlImagem = 'fotos/' . $imagemBanco;
        } elseif ($pokemon['idpokemon'] <= 151) {
            // Usa imagem online apenas para os 151 primeiros
            $idImagem = htmlspecialchars($pokemon['idpokemon']);
            $urlImagem = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$idImagem.png";
        } else {
            $urlImagem = null; // Nenhuma imagem para os outros
        }


            echo "<div class='card'>";
            echo "<img src='$urlImagem' alt='Adicione uma Imagem'>";
            echo "<h2>" . htmlspecialchars($pokemon['nome']) . "</h2>";
            echo "<p><strong>Dex:</strong> " . htmlspecialchars($pokemon['national']) . "</p>";
            echo "<p><strong>Geração:</strong> " . htmlspecialchars($pokemon['gen']) . "</p>";
            
            if (!empty($types)) {
                echo "<p><strong>Tipos:</strong> " . implode(', ', $types) . "</p>";
            }

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
                    break;
                }
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
