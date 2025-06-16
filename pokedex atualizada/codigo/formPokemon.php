<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <form method="POST" action="salvarPokemon.php">
    <?php
      require_once "./conexao.php";
      require_once "./function.php";
      echo "Pokemon:";
      echo "<select name='idpokemon'>";

      $criarpokemon = criarPokemon($conexao);

      foreach($criarpokemon as $pokemon) {
      $idpokemon = $pokemon['idpokemon'];
      $nome = $pokemon['nome'];

      echo "<option value = '$idpokemon'> $nome</option>";
      }
      echo "</select>";

    ?>
<br> <br>
    Hp: <br>
    <input type="text" name="hp" value="<?php echo $hp;?>">
<br> <br>
    Attack: <br>
      <input type="text" name="attack" value="<?php echo $attack;?>">
<br> <br>
    Defense: <br>
    <input type="text" name="defense" value="<?php echo $defense;?>">
<br> <br>
    Special Attack: <br>
    <input type="text" name="spattack" value="<?php echo $sp_attack;?>">
<br> <br>
    Special Defense: <br>
    <input type="text" name="spdefense" value="<?php echo $sp_defense;?>">
<br> <br>
    Speed: <br>
    <input type="text" name="speed" value="<?php echo $speed;?>">
<br> <br>

<?php
require_once "conexao.php";
require_once "function.php";

$lista_types = listarTypes($conexao);

if (!empty($lista_types)) {
    echo "<label>Tipo:</label><br>";
    echo "<select name='produto[]'>";
    foreach ($lista_types as $types) {
        $nome = htmlspecialchars($types['nome']);
        $id = (int)$types['idtypes'];
        echo "<option value='$id'>$nome</option>";
    }
    echo "</select><br><br>";
} else {
    echo "Nenhum tipo encontrado.";
}
?>
      <input type="submit" name="Comprar" value="comprar ">
      </form>
</body>
</html>
