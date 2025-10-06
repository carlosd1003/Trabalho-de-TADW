<?php 
// Inicia a sessão para manter dados do usuário logado
session_start(); 

// Inclui o script que verifica se o usuário está logado
// Caso não esteja, normalmente redireciona para a página de login
require_once 'verificarLogado.php'; 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define o padrão de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade para dispositivos móveis -->
    <title>Document</title> <!-- Título da página -->
    
    <!-- Arquivo CSS personalizado -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Bootstrap CSS para estilização e componentes prontos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
          crossorigin="anonymous">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <!-- 
        d-flex: ativa o Flexbox
        justify-content-center / align-items-center: centraliza horizontal e verticalmente
        vh-100: ocupa 100% da altura da tela
        bg-light: fundo claro 
    -->

    <div class="card p-4 shadow" style="width: 400px;">
        <!-- 
            card: container com borda e sombra
            p-4: padding interno
            shadow: sombra no card
            width: largura fixa
        -->

        <h1 class="text-center text-danger mb-4">Ver As Avaliações</h1>
        <!-- text-center: centraliza o título
             text-danger: cor vermelha
             mb-4: margem inferior -->
        
        <!-- Formulário para envio de reclamações e sugestões -->
        <form action="salvarSuporte.php" method="post" enctype="multipart/form-data" id="form-suporte">
            <!-- 
                action: arquivo PHP que receberá os dados
                method: POST para envio seguro
                enctype: permite envio de arquivos (mesmo que não seja usado agora)
                id: identificador do formulário
            -->

            <!-- Campo de reclamação (opcional) -->
            <div class="mb-3">
                <label for="reclamacao" class="form-label">Fazer Reclamação:</label>
                <input type="text" name="reclamacao" id="reclamacao" class="form-control" placeholder="Opcional" />
            </div>

            <!-- Campo de sugestão (opcional) -->
            <div class="mb-3">
                <label for="sugestao" class="form-label">Fazer Sugestão:</label>
                <input type="text" name="sugestao" id="sugestao" class="form-control" placeholder="Opcional" />
            </div>

            <!-- Campo obrigatório para identificação do usuário -->
            <div class="mb-3">
                <label for="idusuario" class="form-label">Informe o Usuário:</label>
                <input type="text" name="idusuario" id="idusuario" class="form-control" placeholder="Informe Seu Usuário" required />
            </div>

            <!-- Botão de envio do formulário -->
            <button type="submit" class="btn btn-primary w-100">Salvar</button>
        </form>

        <!-- Botão para voltar à página inicial -->
        <a href="home.php" class="btn btn-outline-secondary mt-3 w-100">Voltar</a>
    </div>
</body>

<!-- Script JS do Bootstrap (necessário para alguns componentes funcionarem corretamente) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>

</html>


