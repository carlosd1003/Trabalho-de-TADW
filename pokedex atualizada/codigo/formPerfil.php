<?php
session_start();
require_once 'verificarLogado.php';
?>
<?php
    if (isset($_GET['id'])) {
        // echo "editar";
        require_once "conexao.php";
        require_once "function.php";

        $id = $_GET['id']; 

        $treinador = pesquisarTreinador($conexao, $id);
        $nome = $treinador['nome'];
        $pokemon_fav = $treinador['pokemon_fav'];
        $descricao = $treinador['descricao'];
        $idusuario = $treinador['idusuario'];

        $botao = "Atualizar";
    } else {
        // echo "novo";
        $id = 0;
        $nome = "";
        $pokemon_fav = "";
        $descricao = "";
        $idusuario = "";

        $botao = "Cadastrar";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Perfil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS (optional) -->
    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.7.1.min (1).js"></script>
    <script src="jquery.validate.min.js"></script>
    <script>
        // programar a validação do formulário
        $(document).ready(function () {
            $('#formulario').validate({
                rules: {
                    nome: {
                        required: true,
                        minlength: 3,
                    },
                    idusuario:{
                        required: true,
                        email: true 
                    }
                },
                messages: {
                    nome: {
                        required: "Esse campo não pode ser vazio",
                        minlength: "Tamanho mínimo de 3 símbolos"
                    },
                    idusuario:{
                        required: "Esse campo não pode ser vazio",
                        email: "Por favor, informe um email válido"
                    }
                }
            })
        })
    </script>
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="card p-4 shadow" style="width: 400px;">
        <h1 class="mb-4 text-center text-danger">Criar Perfil</h1>

        <form action="salvarPerfil.php?id=<?php echo $id; ?>" method="post" id="formulario" enctype="multipart/form-data">
            
            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Informe Seu Nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>

            <!-- Pokemon Favorito -->
            <div class="mb-3">
                <label for="pokemon_fav" class="form-label">Seu Pokemon Favorito</label>
                <input type="text" name="pokemon_fav" id="pokemon_fav" class="form-control" placeholder="Informe Seu Pokemon Favorito" value="<?php echo htmlspecialchars($pokemon_fav); ?>" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (Opcional)</label>
                <input type="text" name="descricao" id="descricao" class="form-control" placeholder="Opcional" value="<?php echo htmlspecialchars($descricao); ?>">
            </div>

            <!-- Usuario -->
            <div class="mb-3">
                <label for="idusuario" class="form-label">Usuário</label>
                <input type="text" name="idusuario" id="idusuario" class="form-control" placeholder="Informe Seu Usuário" value="<?php echo htmlspecialchars($idusuario); ?>" required>
            </div>

            <!-- Submit Button -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100"><?php echo $botao; ?></button>
            </div>
        </form>

        <!-- Back Button -->
        <a href="home.php" class="btn btn-outline-secondary w-100 mt-3">Voltar</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
