<?php
    if (isset($_GET['id'])) {
        // echo "editar";

        require_once "conexao.php";
        require_once "function.php";

        $id = $_GET['id'];
        
        $treinador = pesquisarTreinador($conexao, $id);
        $nome = $treinador['nome'];
        $idade = $treinador['idade'];
        $genero = $treinador['genero'];
        $cidade = $treinador['cidade'];
        $regiao = $treinador['regiao'];
        $time_atual = $treinador['time_atual'];
        $data_cadastro = $treinador['data_cadastro'];
        $idpokemon = $treinador['idpokemon'];

        $botao = "Atualizar";
    }
    else {
        // echo "novo";
        $id = 0;
        $nome = "";
        $idade = "";
        $genero = "";
        $cidade = "";
        $regiao = "";
        $time_atual = "";
        $data_cadastro = "";
        $idpokemon = "";

        $botao = "Cadastrar";
    }
?>

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
    <form action="salvar_treinador.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

        nome: <br>
        <input type="text" name="nome" value="<?php echo $nome; ?>"> <br><br>
        Idade: <br>
        <input type="text" name="idade" value="<?php echo $idade; ?>"> <br><br>
        Gênero: <br>
        <input type="text" name="genero"  value="<?php echo $genero; ?>"> <br><br>
        Cidade: <br>
        <input type="text" name="cidade" value="<?php echo $cidade; ?>"> <br><br>
        Região: <br>
        <input type="text" name="regiao" value="<?php echo $regiao; ?>"> <br><br>
        Time Atual: <br>
        <input type="text" name="time_atual" value="<?php echo $time_atual; ?>"> <br><br>
        Data Cadastro: <br>
        <input type="date" name="data" value="<?php echo $data_cadastro; ?>"> <br><br>
        Selecione Um Pokemon:
        <select name="idpokemon" id="idpokemon" value="<?php echo $idpokemon; ?>"> <br>
<?php

        $lista_pokemon = listarPokemon($conexao);
            
            foreach ($lista_pokemon as $pokemon) {
                $idpokemon = $pokemon['idpokemon'];
                $nome = $pokemon['nome'];
                
                echo "<option value='$idpokemon'>$nome</option>";
            }
?>
<br>
        <input type="submit" value="<?php echo $botao; ?>">

    </form>
    <a href="home.php">Voltar</a>

</body>

</html>