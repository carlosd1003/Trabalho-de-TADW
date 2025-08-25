<?php
require_once "conexao.php";
require_once "function.php";


// "isset"
// Verifica se o campo foi enviado no formulário antes de acessar
// Isso evita erros do tipo "Undefined index" caso o usuário não preencha ou o campo não exista
$national = isset($_POST['national']) ? $_POST['national'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$ge = isset($_POST['gen']) ? $_POST['gen'] : '';
$hp = isset($_POST['hp']) ? $_POST['hp'] : 0;
$attack = isset($_POST['attack']) ? $_POST['attack'] : 0;
$defense = isset($_POST['defense']) ? $_POST['defense'] : 0;
$spattack = isset($_POST['spattack']) ? $_POST['spattack'] : 0;
$spdefense = isset($_POST['spdefense']) ? $_POST['spdefense'] : 0;
$speed = isset($_POST['speed']) ? $_POST['speed'] : 0;



// Pega o array de tipos
$types = isset($_POST['types']) ? $_POST['types'] : [];

// Chama a função passando os valores corretos
criarPokemon($conexao, $national, $nome, $hp, $attack, $defense, $spattack, $spdefense, $speed, $types);

header("Location: home.php");
exit;
?>
