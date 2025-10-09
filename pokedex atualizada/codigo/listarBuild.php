<?php
// Inicia a sessão para acessar as variáveis de sessão do usuário
session_start();

// Inclui o script responsável por verificar se o usuário está logado
require_once 'verificarLogado.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna o site responsivo -->
    <title>Lista de Builds</title> <!-- Título da aba do navegador -->
    
    <!-- Importa o arquivo CSS principal do projeto -->
    <link rel="stylesheet" href="style.css">

    <!-- Importa o framework Bootstrap via CDN para estilização e layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
          crossorigin="anonymous">
</head>

<style>
    /* Estilização simples para o título principal */
    h1 {
        color: white;
    }
</style>

<body>
    <!-- Título principal da página -->
    <h1 class="text-center">Lista de Builds</h1>

    <?php
    // Importa os arquivos de conexão com o banco de dados e de funções auxiliares
    require_once "conexao.php";
    require_once "function.php";

    // Recupera todas as builds cadastradas no banco de dados
    $lista_build = listarBuild($conexao);

    // Obtém o tipo de usuário logado (A = Admin, C = Cliente)
    $usuario_tipo = $_SESSION['Tipo'] ?? 'C';

    // Obtém o ID do usuário logado
    $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

    // Verifica se há builds cadastradas no banco
    if (count($lista_build) == 0) {
        // Caso não haja builds, exibe um alerta Bootstrap
        echo "<div class='alert alert-warning text-center' role='alert'>
                Não existem builds cadastradas.
              </div>";
    } else {
        // Caso existam builds, monta a tabela com os dados
    ?>

        <!-- Cria uma tabela para listar todas as builds -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Pokémon</td>
                    <td colspan="2">Ações</td>
                </tr>
            </thead>

            <?php
            // Percorre o array de builds retornado da função listarBuild()
            foreach ($lista_build as $build) {
                // Atribui os valores de cada coluna do banco às variáveis
                $idbuild = $build['idbuild'];
                $nome = $build['nome'];
                $idpokemon = $build['NomeDoPokemon'];

                // Verifica se o campo 'idusuario' existe antes de acessá-lo
                $build_idusuario = isset($build['idusuario']) ? $build['idusuario'] : null;

                // Inicia uma nova linha na tabela
                echo "<tr>";

                // Exibe os valores de cada campo
                echo "<td>$idbuild</td>";
                echo "<td>$nome</td>";
                echo "<td>$idpokemon</td>";

                /**
                 * Controle de Permissões:
                 * - Usuários do tipo 'A' (admin) podem editar e excluir qualquer build.
                 * - Usuários do tipo 'C' (cliente) só podem editar/excluir as builds que criaram.
                 */
                if ($usuario_tipo === 'A' || $usuario_idusuario == $build_idusuario) {
                    // Botão para excluir a build (com confirmação)
                    echo "<td>
                            <a href='deletarBuild.php?id=$idbuild' 
                               class='btn btn-danger'
                               onclick=\"return confirm('Tem certeza que deseja excluir esta build?');\">
                               Excluir
                            </a>
                          </td>";

                    // Botão para editar a build
                    echo "<td>
                            <a href='formCriar_build.php?id=$idbuild' 
                               class='btn btn-warning'>
                               Editar
                            </a>
                          </td>";
                } else {
                    // Usuários sem permissão não veem os botões
                    echo "<td></td><td></td>";
                }

                // Fecha a linha da tabela
                echo "</tr>";
            }
            ?>
        </table>

        </div> <!-- Fecha o container da tabela -->

    <?php
    } // Fim do else
    ?>

    <!-- Botão de retorno à página inicial -->
    <a href="home.php" class="back-button">Voltar</a>

    <!-- Script do Bootstrap para componentes dinâmicos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
</body>

</html>
