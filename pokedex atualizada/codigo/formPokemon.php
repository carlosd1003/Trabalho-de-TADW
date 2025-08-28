<?php
require_once "./conexao.php";
require_once "./function.php";

// ✅ CHAMAR A FUNÇÃO AQUI, ANTES DE USAR NO FORMULÁRIO
$lista_types = listarTypes($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pokémon</title>
</head>
<body>

<h1>Cadastro de Pokémon</h1>

<form method="POST" action="salvarPokemon.php" enctype="multipart/form-data">

    <label>National Dex:<br>
        <input type="number" name="national" required>
    </label><br><br>

    <label>Nome do Pokémon:<br>
        <input type="text" name="nome" required>
    </label><br><br>

    <label>Geração:<br>
        <input type="number" name="gen" required>
    </label><br><br>

    <label>Imagem (opcional):<br>
        <input type="file" name="imagem" accept="image/*">
    </label><br><br>

    <label>HP:<br>
        <input type="number" name="hp" required>
    </label><br><br>

    <label>Attack:<br>
        <input type="number" name="attack" required>
    </label><br><br>

    <label>Defense:<br>
        <input type="number" name="defense" required>
    </label><br><br>

    <label>Special Attack:<br>
        <input type="number" name="sp_attack" required>
    </label><br><br>

    <label>Special Defense:<br>
        <input type="number" name="sp_defense" required>
    </label><br><br>

    <label>Speed:<br>
        <input type="number" name="speed" required>
    </label><br><br>

    <!-- ✅ EXIBE OS TIPOS SOMENTE SE EXISTIREM -->
    <?php
    if (!empty($lista_types)) {
        echo "Tipos (segure Ctrl para selecionar múltiplos):<br>";
        echo "<select name='types[]' multiple required>";
        foreach ($lista_types as $types) {
            $nome = htmlspecialchars($types['nome']);
            $id = (int)$types['idtypes'];
            echo "<option value='$id'>$nome</option>";
        }
        echo "</select><br><br>";
    } else {
        echo "⚠ Nenhum tipo encontrado no banco de dados.<br><br>";
    }
    ?>

    <input type="submit" name="salvar" value="Salvar Pokémon">
</form>

</body>
</html>
