<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="style.css">
</head>

<body>
    Lista De Avaliação
    <?php
    require_once "conexao.php";
    require_once "function.php";

    $lista_suporte = listarSugestao_reclamacao($conexao);

    if (count($lista_suporte) == 0) {
        echo "Não existem clientes cadastrados";
    } else {
    ?>
        <table border="1">
            <tr>
                <td>Id</td>
                <td>Reclamação</td>
                <td>Sugestão</td>
                <td>Email Usuário</td>
                <td colspan="2">Ação</td>
            </tr>
        <?php
        foreach ($lista_suporte as $suporte) {
            $idsuporte = $suporte['idsuporte'];
            $reclamacao = $suporte['reclamacao'];
            $sugestao = $suporte['sugestao'];
            $idusuario = $suporte['idusuario'];
        
        echo "<tr>";
            echo "<td>$idsuporte</td>";
            echo "<td>$reclamacao</td>";
            echo "<td>$sugestao</td>";
            echo "<td>$idusuario</td>";
            echo "<td><a href='deletarSuporte.php?id=$idsuporte'>Excluir</a></td>";
            echo "</tr>";
        }
    }
        ?>
        </table> <br>
<a href="home.php" class="back-button">Voltar</a>
</body>

</html>