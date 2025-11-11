<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro De Usuario</title>

    <!-- ✅ Carrega jQuery e o plugin de validação direto da CDN -->
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
        $(function () {
            $("#cadastro-formulario").validate({
                rules: {
                    nome: {
                        required: true,
                        maxlength: 45
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 45
                    },
                    senha: {
                        required: true,
                        minlength: 6
                    },
                    pokemon_fav: {
                        maxlength: 45
                    },
                    descricao: {
                        maxlength: 45
                    }
                },
                messages: {
                    nome: {
                        required: "Esse campo não pode ser vazio",
                        maxlength: "O nome deve ter no máximo 45 caracteres"
                    },
                    email: {
                        required: "Esse campo não pode ser vazio",
                        email: "Por favor, informe um e-mail válido",
                        maxlength: "O e-mail deve ter no máximo 45 caracteres"
                    },
                    senha: {
                        required: "Esse campo não pode ser vazio",
                        minlength: "A senha deve ter pelo menos 6 caracteres"
                    },
                    pokemon_fav: {
                        maxlength: "O nome do Pokémon deve ter no máximo 45 caracteres"
                    },
                    descricao: {
                        maxlength: "A descrição deve ter no máximo 45 caracteres"
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',

                highlight: function (el) {
                    $(el).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (el) {
                    $(el).removeClass('is-invalid').addClass('is-valid');
                },
            });
        });
    </script>
</head>

<body class="cadastro-page-body">
    <div id="cadastro-container" class="form-container animated-container">
        <h1 id="cadastro-title">Cadastro De Usuario</h1>

        <form id="cadastro-formulario" action="criarUsuario.php" method="post" novalidate>
            <label for="nome" class="cadastro-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="cadastro-text-field" placeholder="Informe seu nome" />

            <label for="email" class="cadastro-label">E-mail:</label>
            <input type="email" id="email" name="email" class="cadastro-text-field" placeholder="Informe seu e-mail" />

            <label for="senha" class="cadastro-label">Senha:</label>
            <input type="password" id="senha" name="senha" class="cadastro-text-field" placeholder="Informe sua senha" />

            <label for="pokemon_fav" class="cadastro-label">Pokémon Favorito:</label>
            <input type="text" id="pokemon_fav" name="pokemon_fav" class="cadastro-text-field" placeholder="Informe seu Pokémon favorito (Opcional)" />

            <label for="descricao" class="cadastro-label">Descrição:</label>
            <textarea id="descricao" name="descricao" class="cadastro-textarea" placeholder="Fale um pouco sobre você (Opcional)"></textarea>

            <input type="submit" id="cadastrar-button" class="cadastro-botao" value="Cadastrar" />
        </form>

        <a href="index.html" id="cadastro-back-button">Voltar</a>
    </div>

    
</body>
</html>
