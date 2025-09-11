<?php
require_once "./conexao.php";
require_once "./function.php";

// CHAMAR A FUNÇÃO AQUI, ANTES DE USAR NO FORMULÁRIO
$lista_types = listarTypes($conexao);
$maiorNational = pegarMaiorNational($conexao);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>Cadastro de Pokémon</h1>

<form method="POST" action="salvarPokemon.php" enctype="multipart/form-data">

    <label>National Dex:<br>
        <input type="text" name="national" required>
    </label><br><br>

    <label>Nome do Pokémon:<br>
        <input type="text" name="nome" required>
    </label><br><br>

    <label>Geração:<br>
        <input type="number" name="gen" min="0" required>
    </label><br><br>

    <label>Imagem (opcional):<br>
        <input type="file" name="imagem">
    </label><br><br>

    <label>HP:<br>
        <input type="number" name="hp" min="0" required>
    </label><br><br>

    <label>Attack:<br>
        <input type="number" name="attack" min="0" required>
    </label><br><br>

    <label>Defense:<br>
        <input type="number" name="defense" min="0" required>
    </label><br><br>

    <label>Special Attack:<br>
        <input type="number" name="spattack" min="0" required>
    </label><br><br>

    <label>Special Defense:<br>
        <input type="number" name="spdefense" min="0" required>
    </label><br><br>

    <label>Speed:<br>
        <input type="number" name="speed" min="0" required>
    </label><br><br>

    <!-- ✅ EXIBE OS TIPOS SOMENTE SE EXISTIREM -->
    <?php
    if (!empty($lista_types)) {
        echo "Tipos (segure Ctrl para selecionar o segundo elemento):<br>";
        echo "<select name='types[]' multiple required>";
        foreach ($lista_types as $types) {
            $nome = htmlspecialchars($types['nome']);
            $id = (int)$types['idtypes'];
            echo "<option value='$id'>$nome</option>";
        }
        echo "</select><br><br>";
    } else {
        echo "Nenhum tipo encontrado no banco de dados.<br><br>";
    }
    ?>

    <input type="submit" class="cadastrar-button" name="salvar" value="Criar Pokémon">

</form>

<script>
  const selectTypes = document.querySelector('select[name="types[]"]');

  selectTypes.addEventListener('change', () => {
    const selectedOptions = Array.from(selectTypes.selectedOptions);
    if (selectedOptions.length > 2) {
      // Se tiver mais de 2 selecionados, desmarca a última seleção
      const lastSelected = selectedOptions[selectedOptions.length - 1];
      lastSelected.selected = false;
    }
  });
</script>


<script>
  const maiorNational = <?php echo $maiorNational; ?>;
</script>
<script>
document.querySelector('form').addEventListener('submit', function(event) {
    const inputNational = this.querySelector('input[name="national"]');
    const valorNational = parseInt(inputNational.value, 10);

    if (isNaN(valorNational)) {
        alert("Por favor, insira um número válido para National Dex.");
        event.preventDefault();
        return;
    }

    if (valorNational <= maiorNational) {
        alert(`O número National Dex deve ser maior que o atual maior cadastrado (${maiorNational}).`);
        event.preventDefault();
        inputNational.focus();
        return;
    }
});

</script>
<a href="home.php" class="back-button">Voltar</a>

</body>
</html>
