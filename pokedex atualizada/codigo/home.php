<?php
session_start();
require_once 'conexao.php';
require_once 'function.php';

// Corrigido aqui para usar o nome da chave certa da sessão
$usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;
$usuario_tipo = $_SESSION['Tipo'] ?? 'C'; // 'C' é o tipo padrão

$nome = trim($_GET['nome'] ?? '');
$tipo = trim($_GET['tipo'] ?? '');
$buscaAtiva = ($nome !== '' || $tipo !== '');


if ($buscaAtiva) {
    if ($nome !== '' && $tipo !== '') {
        $lista_pokemon = pesquisarPokemonPorNomeETipo($conexao, $nome, $tipo);
    } elseif ($nome !== '') {
        $lista_pokemon = pesquisarPokemonNome($conexao, $nome);
    } elseif ($tipo !== '') {
        $lista_pokemon = pesquisarPokemonPorTipo($conexao, $tipo);
    } else {
        $lista_pokemon = [];
    }
} else {
    $lista_pokemon = listarPokemon($conexao);
}


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

<body>
    <!-- Formulário para pesquisa por nome e tipo -->
<form method="get" action="">
  Nome do Pokémon:<br>
  <!-- Campo texto para nome do Pokémon, mantém o valor digitado após envio -->
  <input type="text" name="nome" placeholder="Digite o nome" value="<?= isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '' ?>"><br><br>

  Tipo:<br>
  <!-- Dropdown para selecionar o tipo do Pokémon -->
  <select name="tipo">
    <option value="">Selecione um tipo</option>
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
    <header id="topo">
        <a href="#" id="logo">Pokédex</a>
        <div id="menu-links">
            <a class="btn btn-outline-primary" href="formPokemon.php">Criar Pokémon</a>
            <a class="btn btn-outline-secondary" href="formtreinador.php">Criar Treinador</a>
            <a class="btn btn-outline-success" href="listarTreinador.php">Ver Treinadores</a>
            <a class="btn btn-outline-danger" href="calendario.html">Calendário</a>
            <a class="btn btn-outline-warning" href="formCriar_build.php">Criar Build</a>
            <a class="btn btn-outline-info" href="listarBuild.php">Ver Builds</a>
            <a class="btn btn-outline-dark" href="criarSuporte.php">Acesso Ao Suporte</a>
            <a class="btn btn-outline-danger" href="listarSuporte.php">Ver Informações do Suporte</a>
            <a class="btn btn-outline-success" href="pesquisarTreinador.php">Procurar Treinadores</a>
        </div>
        <a class="perfil" href="formUsuario-home.php"><img src="./img/perfil.png" width="35px" height="35px" alt="Perfil"></a>
    </header> <br>
    <a href="deslogar.php"><img id="porta" src="./img/sair.png" alt="Voltar" width="20px" height="20px"></a> <br> <br>
    <br>
    <a href="quizPokemon.html">
        <img src="./img/bnr_quiz.png" width="100%" height="120px" alt="quiz">
    </a>
    <br><br><br>
    <div class="card-container">
        <?php    
        foreach ($lista_pokemon as $pokemon) {
            $types = buscarTypesDoPokemon($conexao, $pokemon['idpokemon']); // Pega os tipos

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

            // Exibe os tipos com a classe específica para cada tipo
            if (!empty($types)) {
                echo "<div class='types'>";
                foreach ($types as $type) {
                    $classType = strtolower($type); // Transforma o tipo em minúsculo para a classe CSS
                    echo "<span class='type-$classType'>$type</span>";
                }
                echo "</div>";
            }
            echo "<br>";

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

            // Mostrar botões se for admin (tipo 'A') ou dono do Pokémon
            if ($usuario_tipo === 'A' || ($usuario_idusuario && $usuario_idusuario == $pokemon['usuario_idusuario'])) {
                echo "<div class='acoes'>";
                echo "<a href='formPokemon.php?id=" . $pokemon['idpokemon'] . "' class='btn-editar'>Editar</a>";
                echo "<a href='deletarPokemon.php?idpokemon=" . $pokemon['idpokemon'] . "' class='btn-deletar' onclick=\"return confirm('Tem certeza que quer deletar este Pokémon?');\">Deletar</a>";
                echo "</div>";
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>