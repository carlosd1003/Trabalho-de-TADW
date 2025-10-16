<?php
session_start();
require_once 'verificarLogado.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Sugestões e Reclamações</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        h1 {
            color: white;
        }
    </style>
</head>

<body>
    <h1 class="text-center">Pesquisar Sugestões e Reclamações</h1>

    <!-- Formulário de Pesquisa -->
    <form action="pesquisarSuporte.php" method="GET" class="container mt-3 mb-4">
        <div class="input-group">
            <input type="text" name="valor" class="form-control" placeholder="Digite uma palavra-chave (reclamação, sugestão ou email)">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </div>
    </form>

    <div class="container">
        <?php
        if (isset($_GET["valor"]) && !empty($_GET["valor"])) {
            $valor = $_GET["valor"];

            require_once "conexao.php";
            require_once "function.php";

            // Verifica o tipo e o ID do usuário logado
            $usuario_tipo = $_SESSION['Tipo'] ?? 'C';
            $usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

            // Chama a função de pesquisa
            $resultados = pesquisarSugestao_reclamacao($conexao, $valor);

            if (!isset($resultados) || !is_array($resultados) || count($resultados) == 0) {
                echo "<div class='alert alert-warning text-center' role='alert'>Nenhum resultado encontrado.</div>";
            } else {
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead class='table-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Reclamação</th>
                            <th>Sugestão</th>
                            <th>Email Usuário</th>
                            <th colspan='2'>Ações</th>
                        </tr>
                    </thead>
                    <tbody>";

                foreach ($resultados as $sup) {
                    $idsuporte = $sup['idsuporte'];
                    $reclamacao = $sup['reclamacao'];
                    $sugestao = $sup['sugestao'];
                    $email_usuario = $sup['email_usuario'];
                    $idusuario = isset($sup['idusuario']) ? $sup['idusuario'] : null;

                    echo "<tr>";
                    echo "<td>$idsuporte</td>";
                    echo "<td>$reclamacao</td>";
                    echo "<td>$sugestao</td>";
                    echo "<td>$email_usuario</td>";

                    // Exibir botão de exclusão apenas se for admin ou dono da sugestão
                    if ($usuario_tipo === 'A' || $usuario_idusuario == $idusuario) {
                        echo "<td><a href='deletarSuporte.php?id=$idsuporte' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir esta sugestão ou reclamação?');\">Excluir</a></td>";
                    } else {
                        echo "<td></td>";
                    }

                    echo "</tr>";
                }

                echo "</tbody></table>";
            }
        }
        ?>
    </div>

    <div class="container mt-3">
        <a href="listarSugestao_reclamacao.php" class="btn btn-secondary">Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
