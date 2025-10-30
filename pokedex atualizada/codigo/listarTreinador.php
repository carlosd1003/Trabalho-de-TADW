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
<style>
    h1{
        color: white;
    }
</style>
</head>

<body>

        <h1 class="text-center mb-4">Lista de Treinadores</h1>

        <!-- Formulário de Pesquisa Integrado -->
    <form action="listarTreinador.php">
        <div class="input-group mb-3">
            <input class="form-control" placeholder="Pesquisar Treinador" type="text" name="valor">
            <input class="btn btn-primary" type="submit" value="pesquisar">
        </div>
    </form>
        </form> <br>

        <?php
        require_once "conexao.php";
        require_once "function.php";

        // Verifica se o usuário está logado e pega suas informações da sessão
        $usuario_tipo = $_SESSION['Tipo'] ?? 'C';
        $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

        // Verifica se existe pesquisa
        if (isset($_GET["valor"]) && !empty($_GET["valor"])) {
            $valor = $_GET["valor"];
            $lista_treinador = pesquisarTreinador($conexao, $valor);
        } else {
            // Busca todos os treinadores
            $lista_treinador = listarTreinador($conexao);
        }

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

                        if ($usuario_tipo === 'A' or $usuario_idusuario == $treinador_idusuario) {
                            echo "<td><a href='deletar_treinador.php?id=$idtreinador' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir este treinador?');\">Excluir</a></td>";
                            echo "<td><a href='formtreinador.php?id=$idtreinador' class='btn btn-warning'>Editar</a></td>";
                        } else {
                            echo "<td></td><td></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
    </div>
    
<?php } ?>

<a href="home.php" class="back-button">Voltar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>