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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Lista de Treinadores</h1>

        <!-- Formulário de Pesquisa Integrado -->
        <form method="get" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="valor" class="form-control" 
                       placeholder="Pesquisar treinador por nome..." 
                       value="<?= isset($_GET['valor']) ? htmlspecialchars($_GET['valor']) : '' ?>">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
        </form>

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
        <div class="table-responsive">
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
                        
                        // CORREÇÃO: Verifica qual chave contém os nomes dos Pokémon
                        $nomes_pokemons = 'Nenhum Pokémon';
                        
                        if (isset($treinador['pokemon_nome']) && !empty($treinador['pokemon_nome'])) {
                            $nomes_pokemons = $treinador['pokemon_nome'];
                        } elseif (isset($treinador['nome_pokemon']) && !empty($treinador['nome_pokemon'])) {
                            $nomes_pokemons = $treinador['nome_pokemon'];
                        } elseif (isset($treinador['pokemons']) && !empty($treinador['pokemons'])) {
                            $nomes_pokemons = $treinador['pokemons'];
                        } elseif (isset($treinador['pokemon']) && !empty($treinador['pokemon'])) {
                            $nomes_pokemons = $treinador['pokemon'];
                        }

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
                        echo "<td>$nomes_pokemons</td>";

                        if ($usuario_tipo === 'A' || $usuario_idusuario == $treinador_idusuario) {
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

        <a href="home.php" class="btn btn-secondary mt-3">Voltar para Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>