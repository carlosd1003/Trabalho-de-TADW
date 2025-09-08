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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="fundo">
        <header>
        <a href="#" class="logo">Pokédex</a>
        <div>
            <a class="link-topo" href="formPokemon.php">Criar Pokémon</a>
            <a class="link-topo" href="formtreinador.php">Criar Treinador</a>
            <a class="link-topo" href="listarTreinador.php">Ver Treinadores</a>
            <a class="link-topo" href="calendario.html">Calendário</a>
            <a class="link-topo" href="formPerfil.php">Criar Perfil</a>
            <a class="link-topo" href="formCriar_build.php">Criar Build</a>
            <a class="link-topo" href="listarBuild.php">Ver Builds</a>
            <a class="link-topo" href="criarSuporte.php">Acesso Ao Suporte</a>
            <a class="link-topo" href="listarSuporte.php">Ver Informações do Suporte</a>
            <a class="link-topo" href="pesquisarTreinador.php">Procurar Um Treinador</a>
        </div>
    </header>
    <a href="quizPokemon.html">Teste Seu Conhecimento Sobre O Mundo Pokemon</a>
    <br><br><br>
    <h1>Pokédex</h1>
    <div class="card-container">
        <?php
        foreach ($lista_pokemon as $pokemon) {
            $types = buscarTypesDoPokemon($conexao, $pokemon['idpokemon']); // <- Aqui dentro
            
            // Pega a imagem do banco
            $imagemBanco = $pokemon['imagem'];
            
            if (!empty($imagemBanco)) {
                $urlImagem = 'fotos/' . $imagemBanco;
            } else {
                $idImagem = htmlspecialchars($pokemon['idpokemon']);
                $urlImagem = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$idImagem.png";
            }

            echo "<div class='card'>";
            echo "<img src='$urlImagem' alt='Imagem do Pokémon'>";
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
