<?php
session_start();
require_once 'verificarLogado.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Builds</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    h1{
        color: white;
    }
</style>
<body>
    <h1 class="text-center">Lista de Builds</h1>

    <?php
    require_once "conexao.php";
    require_once "function.php";

    $lista_build = listarBuild($conexao);
    $usuario_tipo = $_SESSION['Tipo'] ?? 'C'; // Tipo do usuário (Admin ou 'C' para Cliente)
    $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null; // ID do usuário logado

    if (count($lista_build) == 0) {
        echo "<div class='alert alert-warning text-center' role='alert'>Não existem builds cadastradas.</div>";
    } else {
    ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                        <td>ID</td>
                        <td>Nome</td>
                        <td>Pokémon</td>
                        <td colspan="2">Ações</td>
                </thead>
                    <?php
                    foreach ($lista_build as $build) {
                        $idbuild = $build['idbuild'];
                        $nome = $build['nome'];
                        $idpokemon = $build['NomeDoPokemon'];

                        // Verifica se a chave 'idusuario' existe no array
                        $build_idusuario = isset($build['idusuario']) ? $build['idusuario'] : null;

                        echo "<tr>";
                        echo "<td>$idbuild</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$idpokemon</td>";

                        // Lógica para mostrar os botões apenas para o admin ou o dono da build
                        if ($usuario_tipo === 'A' || $usuario_idusuario == $build_idusuario) {
                            echo "<td><a href='deletarBuild.php?id=$idbuild' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir esta build?');\">Excluir</a></td>";
                            echo "<td><a href='formCriar_build.php?id=$idbuild' class='btn btn-warning'>Editar</a></td>";
                        } else {
                            echo "<td></td><td></td>"; // Sem ações para usuários não autorizados
                        }

                        echo "</tr>";
                    }
                    ?>
            </table>
        </div>
    <?php
    }
    ?>
    
    <a href="home.php" class="back-button">Voltar</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
