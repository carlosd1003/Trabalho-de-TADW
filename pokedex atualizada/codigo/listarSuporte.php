<?php
session_start();
require_once 'verificarLogado.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<style>
    h1{
        color: white;
    }
</style>
<body>
    <h1>Lista De Avaliação</h1>
    <?php
    require_once "conexao.php";
    require_once "function.php";

    $lista_suporte = listarSugestao_reclamacao($conexao);

    if (count($lista_suporte) == 0) {
        echo "Não existem clientes cadastrados";
    } else {
    ?>
        <table class="table">
            <thead class="table-dark">
                <td>Id</td>
                <td>Reclamação</td>
                <td>Sugestão</td>
                <td>Email Usuário</td>
                <td colspan="2">Ação</td>
            </thead>
        <?php
        foreach ($lista_suporte as $suporte) {
            $idsuporte = $suporte['idsuporte'];
            $reclamacao = $suporte['reclamacao'];
            $sugestao = $suporte['sugestao'];
            $idusuario = $suporte['email_usuario'];
        
        echo "<tr>";
            echo "<td>$idsuporte</td>";
            echo "<td>$reclamacao</td>";
            echo "<td>$sugestao</td>";
            echo "<td>$idusuario</td>";
            echo "<td><a class='excluir-button' href='deletarSuporte.php?id=$idsuporte'>Excluir</a></td>";
            echo "</tr>";
        }
    }
        ?>
        </table> <br>
<a href="home.php" class="back-button">Voltar</a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>