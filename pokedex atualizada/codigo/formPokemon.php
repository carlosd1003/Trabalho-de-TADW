<?php
require_once "conexao.php";

// Verificar se está editando
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM pokemon WHERE idpokemon = $id";
    $result = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($result);

    $national = $linha['national'];
    $nome = $linha['nome'];
    $gen = $linha['gen'];

    // Buscar stats
    $sqlStats = "SELECT * FROM stats WHERE idpokemon = $id";
    $resultStats = mysqli_query($conexao, $sqlStats);
    $stats = mysqli_fetch_array($resultStats);

    $hp = $stats['hp'] ?? 0;
    $attack = $stats['attack'] ?? 0;
    $defense = $stats['defense'] ?? 0;
    $sp_attack = $stats['sp_attack'] ?? 0;
    $sp_defense = $stats['sp_defense'] ?? 0;
    $speed = $stats['speed'] ?? 0;

    // Buscar tipos
    $sqlTipos = "SELECT idtypes FROM pokemon_has_types WHERE idpokemon = $id";
    $resultTipos = mysqli_query($conexao, $sqlTipos);
    $tipos = [];
    while ($linhaTipo = mysqli_fetch_array($resultTipos)) {
        $tipos[] = $linhaTipo['idtypes'];
    }

    $botao = "Atualizar";
} else {
    $id = 0;
    $national = "";
    $nome = "";
    $gen = "";
    $hp = $attack = $defense = $sp_attack = $sp_defense = $speed = 0;
    $tipos = [];

    $botao = "Cadastrar";
}

// Buscar todos os tipos para o select
$sqlAllTypes = "SELECT * FROM types";
$resultTypes = mysqli_query($conexao, $sqlAllTypes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pokémon</title>
</head>
<body>
    <h1>Cadastro de Pokémon</h1>

    <form action="salvarPokemon.php?id=<?php echo $id; ?>" method="post">
        <label>National:</label><br>
        <input type="number" name="national" value="<?php echo $national; ?>"><br><br>

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $nome; ?>"><br><br>

        <label>Geração:</label><br>
        <input type="number" name="gen" value="<?php echo $gen; ?>"><br><br>

        <label>Tipo 1:</label><br>
        <select name="tipo1" required>
            <option value="">Selecione</option>
            <?php while($row = mysqli_fetch_array($resultTypes)) { ?>
                <option value="<?php echo $row['idtypes']; ?>" 
                    <?php echo (isset($tipos[0]) && $tipos[0] == $row['idtypes']) ? 'selected' : ''; ?>>
                    <?php echo $row['nome']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <?php
        // Resetando o ponteiro do resultTypes para o segundo select
        mysqli_data_seek($resultTypes, 0);
        ?>

        <label>Tipo 2 (opcional):</label><br>
        <select name="tipo2">
            <option value="">Nenhum</option>
            <?php while($row = mysqli_fetch_array($resultTypes)) { ?>
                <option value="<?php echo $row['idtypes']; ?>" 
                    <?php echo (isset($tipos[1]) && $tipos[1] == $row['idtypes']) ? 'selected' : ''; ?>>
                    <?php echo $row['nome']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <h3>Stats</h3>
        <label>HP:</label><br>
        <input type="number" name="hp" value="<?php echo $hp; ?>"><br><br>

        <label>Attack:</label><br>
        <input type="number" name="attack" value="<?php echo $attack; ?>"><br><br>

        <label>Defense:</label><br>
        <input type="number" name="defense" value="<?php echo $defense; ?>"><br><br>

        <label>Sp. Attack:</label><br>
        <input type="number" name="sp_attack" value="<?php echo $sp_attack; ?>"><br><br>

        <label>Sp. Defense:</label><br>
        <input type="number" name="sp_defense" value="<?php echo $sp_defense; ?>"><br><br>

        <label>Speed:</label><br>
        <input type="number" name="speed" value="<?php echo $speed; ?>"><br><br>

        <input type="submit" value="<?php echo $botao; ?>">
    </form>

    <br><a href="listaPokemon.php">Voltar para Lista</a>
</body>
</html>
