<?php
session_start();
require_once 'verificarLogado.php';
?>
<?php
    require_once "conexao.php";
    require_once "function.php";

// Pega o id do usuário logado
$usuario_idusuario = $_SESSION['usuario_idusuario'];

    // Recebe os dados do formulário
    $national = (int)$_POST['national'];
    $nome = $_POST['nome'];
    $gen = $_POST['gen'];
    $hp = (int)$_POST['hp'];
    $attack = (int)$_POST['attack'];
    $defense = (int)$_POST['defense'];
    $spattack = (int)$_POST['spattack'];
    $spdefense = (int)$_POST['spdefense'];
    $speed = (int)$_POST['speed'];
    $types = $_POST['types']; // Ainda precisa tratar isso conforme seu schema

    $novo_nome = null; // Valor padrão caso não envie imagem

    // Upload da imagem, com validações
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $nome_arquivo = $_FILES['imagem']['name'];
        $caminho_temporario = $_FILES['imagem']['tmp_name'];
        $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

        // Extensões permitidas
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extensao, $extensoes_permitidas)) {
            // Gera nome único
            $novo_nome = uniqid() . "." . $extensao;

            // Verifica se a pasta 'fotos' existe
            $pasta_destino = "fotos";
            if (!is_dir($pasta_destino)) {
                mkdir($pasta_destino, 0755, true);
            }

            $caminho_destino = $pasta_destino . "/" . $novo_nome;

            // Move o arquivo
            if (!move_uploaded_file($caminho_temporario, $caminho_destino)) {
                // Falha ao mover o arquivo
                $novo_nome = null; // Não salva imagem
            }
        }
    }

    // Criar o Pokémon, passando o ID do usuário logado
    $criado = criarPokemon($conexao, $national, $nome, $gen, $novo_nome, $usuario_idusuario);

    if ($criado) {
        $idpokemon = mysqli_insert_id($conexao);
        criarStats($conexao, $idpokemon, $hp, $attack, $defense, $spattack, $spdefense, $speed);

        salvarTypes($conexao, $idpokemon, $types);
    }

    // Redireciona (somente se nenhum erro tiver dado output antes)
    header("Location: home.php");
    exit;
?>
