<?php
session_start();
require_once 'verificarLogado.php';
require_once "./conexao.php";
require_once "./function.php";

$idpokemon = $_GET['id'] ?? null;
$usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

$pokemon = null;
$stats = null;
$types_do_pokemon = [];
$ehDono = false;

if ($idpokemon) {
    // Pega dados do Pokémon, stats e tipos para edição
    $pokemon = pegarPokemonPorId($conexao, (int)$idpokemon);
    $stats = pegarStatsPorPokemon($conexao, (int)$idpokemon);
    $types_do_pokemon = buscarTypesDoPokemon($conexao, (int)$idpokemon);

    // Verifica se o usuário logado é o dono do Pokémon
    if ($pokemon && $pokemon['usuario_idusuario'] == $usuario_idusuario) {
        $ehDono = true;
    }
} else {
    // Se estiver cadastrando novo Pokémon, pode mostrar o botão
    $ehDono = true;
}

$lista_types = listarTypes($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $pokemon ? "Editar Pokémon" : "Cadastro de Pokémon"; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1><?php echo $pokemon ? "Editar Pokémon" : "Cadastro de Pokémon"; ?></h1>

<form method="POST" action="salvarPokemon.php" enctype="multipart/form-data">

    <?php if ($pokemon): ?>
        <input type="hidden" name="idpokemon" value="<?php echo $pokemon['idpokemon']; ?>">
    <?php endif; ?>

    <label>National Dex:<br>
        <input type="number" name="national" required 
            value="<?php echo $pokemon ? htmlspecialchars($pokemon['national']) : ''; ?>">
    </label><br><br>

    <label>Nome do Pokémon:<br>
        <input type="text" name="nome" required 
            value="<?php echo $pokemon ? htmlspecialchars($pokemon['nome']) : ''; ?>">
    </label><br><br>

    <label>Geração:<br>
        <input type="number" name="gen" min="0" required
            value="<?php echo $pokemon ? htmlspecialchars($pokemon['gen']) : ''; ?>">
    </label><br><br>

    <label>Imagem (opcional):<br>
        <input type="file" name="imagem">
    </label>
    <?php if ($pokemon && $pokemon['imagem']): ?>
        <br>Imagem atual: <img src="fotos/<?php echo htmlspecialchars($pokemon['imagem']); ?>" alt="Imagem do Pokémon" width="80">
    <?php endif; ?>
    <br><br>

    <label>HP:<br>
        <input type="number" name="hp" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['hp']) : ''; ?>">
    </label><br><br>

    <label>Attack:<br>
        <input type="number" name="attack" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['attack']) : ''; ?>">
    </label><br><br>

    <label>Defense:<br>
        <input type="number" name="defense" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['defense']) : ''; ?>">
    </label><br><br>

    <label>Special Attack:<br>
        <input type="number" name="spattack" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['sp_attack']) : ''; ?>">
    </label><br><br>

    <label>Special Defense:<br>
        <input type="number" name="spdefense" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['sp_defense']) : ''; ?>">
    </label><br><br>

    <label>Speed:<br>
        <input type="number" name="speed" min="0" required
            value="<?php echo $stats ? htmlspecialchars($stats['speed']) : ''; ?>">
    </label><br><br>

    <label>Tipos (segure Ctrl para selecionar até 2):<br>
        <select name="types[]" multiple required>
            <?php
            foreach ($lista_types as $type) {
                $selected = in_array($type['nome'], $types_do_pokemon) ? 'selected' : '';
                echo "<option value='" . (int)$type['idtypes'] . "' $selected>" . htmlspecialchars($type['nome']) . "</option>";
            }
            ?>
        </select>
    </label><br><br>

    <?php if ($ehDono): ?>
        <input type="submit" value="<?php echo $pokemon ? "Salvar Alterações" : "Criar Pokémon"; ?>" class="btn-salvar">
    <?php else: ?>
        <p style="color: red; font-weight: bold;">Você não tem permissão para editar este Pokémon.</p>
    <?php endif; ?>

</form>

<script>
  const selectTypes = document.querySelector('select[name="types[]"]');
  selectTypes.addEventListener('change', () => {
    const selectedOptions = Array.from(selectTypes.selectedOptions);
    if (selectedOptions.length > 2) {
      selectedOptions[selectedOptions.length - 1].selected = false;
      alert('Selecione no máximo 2 tipos.');
    }
  });
</script>

<a href="home.php" class="back-button">Voltar</a>

</body>
</html>
