<?php
session_start();
require_once 'verificarLogado.php';
require_once 'conexao.php';
require_once 'function.php';

$id = $_SESSION['idusuario']; // pega o usuário da sessão

// Busca os dados do usuário logado
$usuario = pesquisarUsuarioId($conexao, $id);

if ($usuario) {
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $senha = $usuario['senha']; // hash
    $pokemon_fav = $usuario['pokemon_fav'];
    $descricao = $usuario['descricao'];
    $botao = "Atualizar";
} else {
    // Caso improvável, se usuário não existir
    $nome = $email = $senha = $pokemon_fav = $descricao = "";
    $botao = "Cadastrar";
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $botao; ?> de Usuário</title>
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="jquery-3.7.1.min.js"></script>
    <script src="jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cadastro-formulario').validate({
                rules: {
                    nome: { required: true, maxlength: 45 },
                    email: { required: true, email: true },
                    senha: { minlength: 6 }
                },
                messages: {
                    nome: { required: "Esse campo não pode ser vazio", maxlength: "O nome deve ter no máximo 45 caracteres" },
                    email: { required: "Esse campo não pode ser vazio", email: "Por favor, informe um e-mail válido" },
                    senha: { minlength: "A senha deve ter pelo menos 6 caracteres" }
                }
            });
        });
    </script>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow" style="width: 420px;">
        <h1 class="text-center text-danger mb-4"><?php echo $botao; ?> de Usuário</h1>

        <form action="salvarUsuario.php?id=<?php echo $id; ?>" method="post" id="cadastro-formulario" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Informe Seu Nome" value="<?php echo htmlspecialchars($nome); ?>" required maxlength="45" />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Informe Seu E-mail" value="<?php echo htmlspecialchars($email); ?>" required maxlength="45" />
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" placeholder="Informe uma nova senha (opcional)" minlength="6" />
            </div>

            <div class="mb-3">
                <label for="pokemon_fav" class="form-label">Pokémon Favorito:</label>
                <input type="text" id="pokemon_fav" name="pokemon_fav" class="form-control" placeholder="Informe Seu Pokémon Favorito" value="<?php echo htmlspecialchars($pokemon_fav); ?>" maxlength="45" />
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" placeholder="Fale um pouco sobre você" maxlength="45"><?php echo htmlspecialchars($descricao); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100"><?php echo $botao; ?></button>
        </form>

<a href="home.php"class="btn btn-warning mt-3 w-100">voltar</a>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
