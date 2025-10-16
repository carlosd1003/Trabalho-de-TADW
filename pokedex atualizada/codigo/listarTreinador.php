<?php
session_start();
require_once 'verificarLogado.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Treinadores</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<style>
    h1 {
        color: white;
    }
</style>

<body>
    <h1 class="text-center">Lista de Treinadores</h1>

    <?php
    require_once "conexao.php";
    require_once "function.php";

    // Verifica se o usuário está logado e pega suas informações da sessão
    $usuario_tipo = $_SESSION['Tipo'] ?? 'C'; // 'A' = Admin, 'C' = Cliente
    $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null; // ID do usuário logado

    // Busca os treinadores cadastrados
    $lista_treinador = listarTreinador($conexao);

    // Se não houver nenhum treinador, exibe uma mensagem
    if (count($lista_treinador) == 0) {
        echo "<div class='alert alert-warning text-center' role='alert'>Não existem treinadores cadastrados.</div>";
    } else {
    ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Gênero</th>
                    <th>Cidade</th>
                    <th>Região</th>
                    <th>Time Atual</th>
                    <th>Data</th>
                    <th>Pokémons</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($lista_treinador as $treinador) {
                $idtreinador = $treinador['idtreinador'];
                $nome = $treinador['nome'];
                $idade = $treinador['idade'];
                $genero = $treinador['genero'];
                $cidade = $treinador['cidade'];
                $regiao = $treinador['regiao'];
                $time_atual = $treinador['time_atual'];
                $data_cadastro = $treinador['data_cadastro'];
                $idpokemon = $treinador['pokemon_nome'];

                // Verifica se a chave 'idusuario' existe no array, caso contrário atribui null
                $treinador_idusuario = isset($treinador['idusuario']) ? $treinador['idusuario'] : null;

                echo "<tr>";
                echo "<td>$idtreinador</td>";
                echo "<td>$nome</td>";
                echo "<td>$idade</td>";
                echo "<td>$genero</td>";
                echo "<td>$cidade</td>";
                echo "<td>$regiao</td>";
                echo "<td>$time_atual</td>";
                echo "<td>$data_cadastro</td>";
                echo "<td>$idpokemon</td>";

                // Lógica para exibir os botões de ação: Editar e Excluir
                if ($usuario_tipo === 'A' || $usuario_idusuario == $treinador_idusuario) {
                    echo "<td><a href='deletar_treinador.php?id=$idtreinador' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir este treinador?');\">Excluir</a></td>";
                    echo "<td><a href='formtreinador.php?id=$idtreinador' class='btn btn-warning'>Editar</a></td>";
                } else {
                    // Caso não seja admin ou o próprio dono, sem opções de edição ou exclusão
                    echo "<td></td><td></td>";
                }

                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
            ?>

            <a href="home.php" class="back-button">Voltar</a>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>