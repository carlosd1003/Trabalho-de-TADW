<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Usuario</title>
    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.7.1.min.js"></script>
    <script src="jquery.validate.min.js"></script>
    <script>
        // Programar a validação do formulário
        $(document).ready(function () {
            $('#cadastro-formulario').validate({
                rules: {
                    nome: {
                        required: true,
                        maxlength: 45
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    senha: {
                        required: true,
                        minlength: 6
                    }

                },
                messages: {
                    nome: {
                        required: "Esse campo não pode ser vazio",
                        maxlength: "O nome deve ter no máximo 45 caracteres"
                    },
                    email: {
                        required: "Esse campo não pode ser vazio",
                        email: "Por favor, informe um e-mail válido"
                    },
                    senha: {
                        required: "Esse campo não pode ser vazio",
                        minlength: "A senha deve ter pelo menos 6 caracteres"
                    }

                }
            });
        });
    </script>
</head>

<body class="cadastro-page-body">
    <div id="cadastro-container" class="form-container animated-container">
        <h1 id="cadastro-title">Cadastro De Usuario</h1>
        <form id="cadastro-formulario" action="salvarUsuario.php" method="post">
            <!-- Campo Nome -->
            <label for="nome" class="cadastro-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="cadastro-text-field" required maxlength="45" placeholder="Informe seu nome" />

            <!-- Campo E-mail -->
            <label for="email" class="cadastro-label">E-mail:</label>
            <input type="email" id="email" name="email" class="cadastro-text-field" required maxlength="45" placeholder="Informe seu e-mail" />

            <!-- Campo Senha -->
            <label for="senha" class="cadastro-label">Senha:</label>
            <input type="password" id="senha" name="senha" class="cadastro-text-field" placeholder="Informe sua senha" />

            <!-- Campo Pokémon Favorito -->
            <label for="pokemon_fav" class="cadastro-label">Pokémon Favorito:</label>
            <input type="text" id="pokemon_fav" name="pokemon_fav" class="cadastro-text-field" maxlength="45" placeholder="Informe seu Pokémon favorito" />

            <!-- Campo Descrição -->
            <label for="descricao" class="cadastro-label">Descrição:</label>
            <textarea id="descricao" name="descricao" class="cadastro-textarea" maxlength="45" placeholder="Fale um pouco sobre você"></textarea>

            <!-- Botão de envio -->
            <input type="submit" id="cadastrar-button" class="cadastro-botao" value="Cadastrar" />
        </form>

        <!-- Link para voltar -->
        <a href="index.html" id="cadastro-back-button">Voltar</a>
    </div>
</body>

</html>