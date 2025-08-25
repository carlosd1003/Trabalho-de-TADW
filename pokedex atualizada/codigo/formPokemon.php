<?php
require_once "./conexao.php";
require_once "./function.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pokémon</title>
</head>
<body>

<form method="POST" action="salvarPokemon.php" enctype="multipart/form-data">


National:<br>
<input type="text" name="national"><br><br>

Nome do Pokémon:<br>
<input type="text" name="nome"><br><br>

Geração:<br>
<input type="text" name="gen"><br><br>

Imagem:<br>
<input type="file" name="imagem"><br><br>




    Hp:<br>
    <input type="text" name="hp"><br><br>

    Attack:<br>
    <input type="text" name="attack"><br><br>

    Defense:<br>
    <input type="text" name="defense"><br><br>

    Special Attack:<br>
    <input type="text" name="spattack"><br><br>

    Special Defense:<br>
    <input type="text" name="spdefense"><br><br>

    Speed:<br>
    <input type="text" name="speed"><br><br>

    <?php
    //vai pegar a função feita e guardar
    $lista_types = listarTypes($conexao);

    if (!empty($lista_types)) {
        echo "Tipo:<br>";
        echo "<select name='types[]' multiple>";
        foreach ($lista_types as $types) {
            $nome = htmlspecialchars($types['nome']);
            $id = (int)$types['idtypes'];
            echo "<option value='$id'>$nome</option>";
        }
        echo "</select><br><br>";
    } else {
        echo "Nenhum tipo encontrado.<br><br>";
    }
    ?>

    <input type="submit" name="salvar" value="Salvar">
</form>

</body>
</html>
