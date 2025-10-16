<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pesquisar Pokémon</title>
  <style>
    /* Estilos para o card do Pokémon e suas estatísticas */
    .card { border: 1px solid #ccc; padding: 10px; margin-bottom: 15px; max-width: 300px; }
    .stats p { margin: 3px 0; }
    img { max-width: 150px; }
  </style>
</head>
<body>

<!-- Formulário para pesquisa por nome e tipo -->
<form method="get" action="">
  Nome do Pokémon:<br>
  <!-- Campo texto para nome do Pokémon, mantém o valor digitado após envio -->
  <input type="text" name="nome" placeholder="Digite o nome" value="<?= isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '' ?>"><br><br>

  Tipo:<br>
  <!-- Dropdown para selecionar o tipo do Pokémon -->
  <select name="tipo">
    <option value="">--Selecione um tipo--</option>
    <?php
    // Inclui conexao e funções para acessar o banco
    require_once "conexao.php";
    require_once "function.php";

    // Busca todos os tipos no banco e preenche o select
    $tipos = listarTypes($conexao);
    foreach ($tipos as $t) {
        // Mantém selecionado o tipo escolhido pelo usuário após envio
        $sel = (isset($_GET['tipo']) && $_GET['tipo'] === $t['nome']) ? "selected" : "";
        echo "<option value=\"" . htmlspecialchars($t['nome']) . "\" $sel>" . htmlspecialchars($t['nome']) . "</option>";
    }
    ?>
  </select><br><br>

  <!-- Botão para enviar o formulário -->
  <input type="submit" value="Pesquisar">
</form>

<?php
// Verifica se pelo menos um dos filtros (nome ou tipo) foi preenchido
if ((!empty($_GET['nome']) && trim($_GET['nome']) !== "") || (!empty($_GET['tipo']) && trim($_GET['tipo']) !== "")) {
    // Recebe e limpa os valores enviados
    $nome = trim($_GET['nome'] ?? '');
    $tipo = trim($_GET['tipo'] ?? '');

    // Inclui novamente conexao e funções (pode otimizar para incluir só uma vez)
    require_once "conexao.php";
    require_once "function.php";

    // Busca os pokémons conforme os filtros aplicados
    if ($nome !== '' && $tipo !== '') {
        // Pesquisa por nome e tipo juntos
        $resultados = pesquisarPokemonPorNomeETipo($conexao, $nome, $tipo);
    } elseif ($nome !== '') {
        // Pesquisa somente por nome
        $resultados = pesquisarPokemonNome($conexao, $nome);
    } elseif ($tipo !== '') {
        // Pesquisa somente por tipo
        $resultados = pesquisarPokemonPorTipo($conexao, $tipo);
    } else {
        // Se nenhum filtro, resultado vazio
        $resultados = [];
    }

    // Caso alguma função retorne falso, ajusta para array vazio
    if (!$resultados) {
        $resultados = [];
    }

    // Se encontrou pokémons, exibe cada um
    if (count($resultados) > 0) {
        foreach ($resultados as $pokemon) {
            mostrarPokemon($pokemon, $conexao);
        }
    } else {
        // Se não encontrou nenhum pokémon, mostra mensagem
        echo "<p>Nenhum Pokémon encontrado.</p>";
    }
}

// Função para exibir os dados e stats do pokémon na tela
function mostrarPokemon($pokemon, $conexao) {
    static $lista_stats = null;
    // Carrega lista de stats apenas uma vez
    if ($lista_stats === null) {
        $lista_stats = listarStats($conexao);
    }

    // Busca tipos do pokémon (array de strings)
    $types = buscarTypesDoPokemon($conexao, $pokemon['idpokemon']);

    // Define a URL da imagem, priorizando imagem local
    $imagemBanco = $pokemon['imagem'];
    if (!empty($imagemBanco)) {
        $urlImagem = 'fotos/' . $imagemBanco;
    } elseif ($pokemon['idpokemon'] <= 151) {
        // Usa imagem online para os primeiros 151 pokémons
        $idImagem = htmlspecialchars($pokemon['idpokemon']);
        $urlImagem = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$idImagem.png";
    } else {
        $urlImagem = null;
    }

    // Monta o card com as informações
    echo "<div class='card'>";
    if ($urlImagem) {
        echo "<img src='$urlImagem' alt='Imagem do Pokémon'>";
    } else {
        echo "<p>[Sem imagem]</p>";
    }
    echo "<h2>" . htmlspecialchars($pokemon['nome']) . "</h2>";
    echo "<p><strong>Dex:</strong> " . htmlspecialchars($pokemon['national']) . "</p>";
    echo "<p><strong>Geração:</strong> " . htmlspecialchars($pokemon['gen']) . "</p>";

    // Exibe as estatísticas do pokémon correspondentes
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
</body>
</html>
