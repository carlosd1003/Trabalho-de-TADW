<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        require_once "conexao.php";
        require_once "function.php";
    ?>
    <form action="salvar_treinador.php" method="post">

        nome: <br>
        <input type="text" name="nome"> <br><br>
        Idade: <br>
        <input type="text" name="idade"> <br><br>
        Gênero: <br>
        <input type="text" name="genero"> <br><br>
        Cidade: <br>
        <input type="text" name="cidade"> <br><br>
        Região: <br>
        <input type="text" name="regiao"> <br><br>
        Time Atual: <br>
        <input type="text" name="time_atual"> <br><br>
        Data Cadastro: <br>
        <input type="date" name="data"> <br><br>
        Selecione Um Pokemon:
        <select name="idpokemon" id="idpokemon">
<?php

        $lista_pokemon = listarPokemon($conexao);
            
            foreach ($lista_pokemon as $pokemon) {
                $idpokemon = $pokemon['idpokemon'];
                $nome = $pokemon['nome'];
                
                echo "<option value='$idpokemon'>$nome</option>";
            }
?>
<br>
        <input type="submit" value="Cadastrar">

    </form>
</body>

</html>