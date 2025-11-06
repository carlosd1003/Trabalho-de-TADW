<?php
// Inicia a sessão e garante que o usuário está logado.
session_start();
require_once 'verificarLogado.php';

// Inclui dependências de conexão e funções.
require_once 'conexao.php';
require_once 'function.php';

/**
 * Captura dados do usuário logado a partir da sessão.
 * Se não existirem, atribuímos valores padrão seguros.
 * - Tipo padrão 'C' (comum)
 * - ID do usuário pode ser null (sem associação)
 */
$usuario_tipo = $_SESSION['Tipo']            ?? 'C';
$usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

/**
 * Verifica se foi enviada uma busca via GET (?valor=...).
 * - Quando houver termo, chama pesquisarTreinador($conexao, $valor).
 * - Caso contrário, carrega todos os treinadores com listarTreinador($conexao).
 *
 * IMPORTANTE: As funções devem usar consultas preparadas/parametrizadas internamente
 * para prevenir SQL Injection. Este arquivo não constrói SQL diretamente.
 */
$lista_treinador = [];
if (isset($_GET['valor']) && $_GET['valor'] !== '') {
    $valor = $_GET['valor'];
    $lista_treinador = pesquisarTreinador($conexao, $valor);
} else {
    $lista_treinador = listarTreinador($conexao);
}

/**
 * Helper para escapar com segurança valores que vão para o HTML.
 */
function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Treinadores</title>

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    <style>
        h1 { color: white; }
    </style>
</head>
<body class="bg-dark">
    <div class="container py-4">
        <!-- Título da página -->
        <h1 class="text-center mb-4">Lista de Treinadores</h1>

        <!-- Formulário de Pesquisa
             - Método GET para permitir compartilhamento de URL com o termo de busca.
             - Campo 'valor' usado pelo backend.
        -->
        <form action="listarTreinador.php" method="get" class="mb-3">
            <div class="input-group">
                <input
                    class="form-control"
                    placeholder="Pesquisar Treinador"
                    type="text"
                    name="valor"
                    value="<?php echo isset($valor) ? e($valor) : ''; ?>"
                >
                <button class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>

        <?php if (empty($lista_treinador)) : ?>
            <!-- Mensagem quando não há registros -->
            <div class="alert alert-warning text-center" role="alert">
                Não existem treinadores cadastrados.
            </div>
        <?php else : ?>
            <!-- Tabela de resultados -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle bg-white">
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
                            <th colspan="2" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_treinador as $treinador) :
                            // Mapeia campos vindos do banco. Use nomes consistentes no SELECT para evitar confusão.
                            $idtreinador      = $treinador['idtreinador']      ?? null;
                            $nome             = $treinador['nome']             ?? '';
                            $idade            = $treinador['idade']            ?? '';
                            $genero           = $treinador['genero']           ?? '';
                            $cidade           = $treinador['cidade']           ?? '';
                            $regiao           = $treinador['regiao']           ?? '';
                            $time_atual       = $treinador['time_atual']       ?? '';
                            $data_cadastro    = $treinador['data_cadastro']    ?? '';
                            // No código original, a variável se chamava $idpokemon mas recebia 'pokemon_nome'.
                            // Aqui, usamos um nome coerente:
                            $pokemon_nome     = $treinador['pokemon_nome']     ?? '';
                            // ID do usuário dono do registro (se existir no SELECT):
                            $treinador_idusuario = $treinador['idusuario']     ?? null;

                            // Regra de permissão (mantida do original):
                            // - Admin (Tipo 'A') pode editar/excluir todos os registros;
                            // - Dono do registro também pode editar/excluir;
                            // - Usuário comum (Tipo 'C') pode editar/excluir quando idtreinador > 50.
                            $pode_gerenciar = (
                                ($usuario_tipo === 'A') ||
                                ($usuario_idusuario !== null && $usuario_idusuario == $treinador_idusuario) ||
                                ($usuario_tipo === 'C' && is_numeric($idtreinador) && (int)$idtreinador > 50)
                            );

                            // Formata data caso venha em formato padrão 'Y-m-d H:i:s'
                            $data_formatada = $data_cadastro;
                            if ($data_cadastro) {
                                $timestamp = strtotime($data_cadastro);
                                if ($timestamp !== false) {
                                    $data_formatada = date('d/m/Y H:i', $timestamp);
                                }
                            }
                        ?>
                            <tr>
                                <td><?php echo e($idtreinador); ?></td>
                                <td><?php echo e($nome); ?></td>
                                <td><?php echo e($idade); ?></td>
                                <td><?php echo e($genero); ?></td>
                                <td><?php echo e($cidade); ?></td>
                                <td><?php echo e($regiao); ?></td>
                                <td><?php echo e($time_atual); ?></td>
                                <td><?php echo e($data_formatada); ?></td>
                                <td><?php echo e($pokemon_nome); ?></td>
                                <?php if ($pode_gerenciar): ?>
                                    <td class="text-center">
                                        <a
                                            href="deletar_treinador.php?id=<?php echo urlencode((string)$idtreinador); ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este treinador?');"
                                        >Excluir</a>
                                    </td>
                                    <td class="text-center">
                                        <a
                                            href="formtreinador.php?id=<?php echo urlencode((string)$idtreinador); ?>"
                                            class="btn btn-warning"
                                        >Editar</a>
                                    </td>
                                <?php else: ?>
                                    <td></td>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Link de retorno -->
        <div class="mt-3">
            <a href="home.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <!-- Bootstrap JS (bundle com Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"
    ></script>
</body>
</html>