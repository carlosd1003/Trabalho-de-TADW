<?php
// Inicia a sessão para acessar as variáveis de sessão do usuário
session_start();

// Inclui o script responsável por verificar se o usuário está logado
require_once 'verificarLogado.php';
?>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>Lista de Avaliação</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<style>

    h1 {
color: white;
}
</style>

<body>
    <h1>Lista De Avaliação</h1>
    <h1 class="text-center">Lista de Sugestões e Reclamações</h1>

<?php
require_once "conexao.php";
require_once "function.php";

    // Verifica se o usuário está logado e pega suas informações da sessão
    $usuario_tipo = $_SESSION['Tipo'] ?? 'C'; // 'A' = Admin, 'C' = Cliente
    $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null; // ID do usuário logado

    // Busca as sugestões e reclamações
$lista_suporte = listarSugestao_reclamacao($conexao);

    // Se não houver nenhum suporte, exibe uma mensagem
if (count($lista_suporte) == 0) {
        echo "Não existem clientes cadastrados";
        echo "<div class='alert alert-warning text-center' role='alert'>Não existem sugestões ou reclamações cadastradas.</div>";
} else {
?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Reclamação</th>
                        <th>Sugestão</th>
                        <th>Email Usuário</th>
                        <th colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lista_suporte as $suporte) {
                        $idsuporte = $suporte['idsuporte'];
                        $reclamacao = $suporte['reclamacao'];
                        $sugestao = $suporte['sugestao'];
                        $email_usuario = $suporte['email_usuario'];

                        // Verifica se a chave 'idusuario' existe no array, caso contrário atribui null
                        $suporte_idusuario = isset($suporte['idusuario']) ? $suporte['idusuario'] : null;

                        echo "<tr>";
                        echo "<td>$idsuporte</td>";
                        echo "<td>$reclamacao</td>";
                        echo "<td>$sugestao</td>";
                        echo "<td>$email_usuario</td>";

                        // Lógica para exibir botões de ações
                        if ($usuario_tipo === 'A' || $usuario_idusuario == $suporte_idusuario) {
                            echo "<td><a href='deletarSuporte.php?id=$idsuporte' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir esta sugestão ou reclamação?');\">Excluir</a></td>";
                        } else {
                            echo "<td></td>"; // Sem ação para usuários não autorizados
                        }

                        echo "</tr>";
                    }
                }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
        ?>
    <a href="home.php" class="back-button">Voltar</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>