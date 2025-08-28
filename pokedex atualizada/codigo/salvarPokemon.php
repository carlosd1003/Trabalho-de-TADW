<?php
require_once "conexao.php";
require_once "function.php";

// Recebe os dados do formulário com isset para evitar erros
$national = isset($_POST['national']) ;
$nome = isset($_POST['nome']) ;
$gen = isset($_POST['gen']);
$hp = isset($_POST['hp']);
$attack = isset($_POST['attack']);
$defense = isset($_POST['defense']);
$spattack = isset($_POST['spattack']);
$spdefense = isset($_POST['spdefense']);
$speed = isset($_POST['speed']);

// Pega o array de tipos
$types = isset($_POST['types']);

$nome_arquivo = $_FILES['imagem']['name'];
$caminho_temporario = $_FILES['imagem']['tmp_name'];

//pega a extensão do arquivo
$extensao = pathinfo($nome_arquivo, PATHINFO_EXTENSION);

//gerar um novo nome para o arquivo
$novo_nome = uniqid() . "." . $extensao;

//criar um novo caminho para o arquivo
// lembre-se de criar a pasta e ajustar as permissões
$caminho_destino = "fotos/" . $novo_nome;

// move a foto para o servidor
move_uploaded_file($caminho_temporario, $caminho_destino);


// Se não existe, pode criar o Pokémon
criarPokemon($conexao, $national, $nome, $gen, $novo_nome, $hp, $attack, $defense, $spattack, $spdefense, $speed, $types);

// Redireciona para a home após inserir
header("Location: home.php");
exit;
?>
