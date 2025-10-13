<?php
session_start();
require_once 'verificarLogado.php';
require_once "./conexao.php";
require_once "./function.php";

$idpokemon = $_GET['id'] ?? null;
$usuario_idusuario = $_SESSION['usuario_idusuario'] ?? null;

$pokemon = null;
$stats = null;
$types_do_pokemon = [];
$ehDono = false;

if ($idpokemon) {
    $pokemon = pegarPokemonPorId($conexao, (int)$idpokemon);
    $stats = pegarStatsPorPokemon($conexao, (int)$idpokemon);
    $types_do_pokemon = buscarTypesDoPokemon($conexao, (int)$idpokemon);

    if ($pokemon && $pokemon['usuario_idusuario'] == $usuario_idusuario) {
        $ehDono = true;
    }
} else {
    $ehDono = true;
}

$lista_types = listarTypes($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title><?php echo $pokemon ? "Editar Pokémon" : "Cadastro de Pokémon"; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="style.css" />
    <style>
        /* Para o select múltiplo ficar mais legível */
        select[multiple] {
            height: auto;
        }
    </style>
    <script src="jquery-3.7.1.min (1).js"></script>
    <script src="jquery.validate.min.js"></script>
    <script>
        // programar a validação do formulário
        $(document).ready(function () {
        // Passa o valor do último número criado para uma variável JS
        var ultimoNumeroCriado = <?php echo $ultimo_numero_criado ?? 0; ?>;

        // Cria uma regra personalizada para validar se o número é maior que ultimoNumeroCriado
        $.validator.addMethod("maiorQueUltimo", function(value, element) {
            return this.optional(element) || Number(value) > ultimoNumeroCriado;
        }, "O número deve ser maior que o último criado: " + ultimoNumeroCriado);
            $('#formulario').validate({
                rules: {
                    national: {
                        required: true,
                        number: true,
                        maiorQueUltimo: true
                        
                    },
                    nome:{
                        required: true,
                        minlength: 3,
                        
                    },
                    gen:{
                        required: true,
                        number: true,
                        min: 1

                    },
                    hp:{
                        required: true,
                        number: true,
                        min: 1                       
                    },
                    attack:{
                        required: true,
                        number: true,
                        min: 1                    
                    },
                    defense:{
                        required: true,
                        number: true,
                        min: 1                    
                    },
                    spattack:{
                        required: true,
                        number: true,
                        min: 1 
                    },
                    spdefense:{
                        required: true,
                        number: true,
                        min: 1 
                    },
                    speed:{
                        required: true,
                        number: true,
                        min: 1 
                    },

                },
                messages: {
                    national: {
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        maiorQueUltimo: "O número deve ser maior que o último criado: " + ultimoNumeroCriado
                    },
                    nome:{
                        required: "Esse campo não pode ser vazio",
                        minlength: "Esse campo tem que ter mais de 3 caracteres"
                    },
                    gen:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    hp:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    attack:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    defense:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    spattack:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    spdefense:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },
                    speed:{
                        required: "Esse campo não pode ser vazio",
                        number: "Informe um número válido",
                        min: "O número precisa ser maior que 0"
                    },

                }
            })
        })
    </script>
</head>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 450px;">
            <h1 class="text-center mb-4 text-danger fw-bold"><?php echo $pokemon ? "Editar Pokémon" : "Cadastro de Pokémon"; ?></h1>


        <form method="POST" action="salvarPokemon.php" id="formulario" enctype="multipart/form-data" novalidate>
            <?php if ($pokemon): ?>
                <input type="hidden" name="idpokemon" value="<?php echo $pokemon['idpokemon']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="national" class="form-label">National Dex:</label>
                <input type="number" id="national" name="national" class="form-control" 
                    value="<?php echo $pokemon ? htmlspecialchars($pokemon['national']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Pokémon:</label>
                <input type="text" id="nome" name="nome" class="form-control"
                    value="<?php echo $pokemon ? htmlspecialchars($pokemon['nome']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="gen" class="form-label">Geração:</label>
                <input type="number" id="gen" name="gen" class="form-control"
                    value="<?php echo $pokemon ? htmlspecialchars($pokemon['gen']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem (opcional):</label>
                <input type="file" id="imagem" name="imagem" class="form-control">
                <?php if ($pokemon && $pokemon['imagem']): ?>
                    <div class="mt-2">
                        <img src="fotos/<?php echo htmlspecialchars($pokemon['imagem']); ?>" alt="Imagem do Pokémon" width="80" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="hp" class="form-label">HP:</label>
                <input type="number" id="hp" name="hp"  class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['hp']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="attack" class="form-label">Attack:</label>
                <input type="number" id="attack" name="attack"  class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['attack']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="defense" class="form-label">Defense:</label>
                <input type="number" id="defense" name="defense"  class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['defense']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="spattack" class="form-label">Special Attack:</label>
                <input type="number" id="spattack" name="spattack"  class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['sp_attack']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="spdefense" class="form-label">Special Defense:</label>
                <input type="number" id="spdefense" name="spdefense"  class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['sp_defense']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="speed" class="form-label">Speed:</label>
                <input type="number" id="speed" name="speed" class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['speed']) : ''; ?>">
            </div>

            <div class="mb-4">
                <label for="types" class="form-label">Tipos (segure Ctrl para selecionar até 2):</label>
                <select id="types" name="types[]" class="form-select" multiple required>
                    <?php
                    foreach ($lista_types as $type) {
                        $selected = in_array($type['nome'], $types_do_pokemon) ? 'selected' : '';
                        echo "<option value='" . (int)$type['idtypes'] . "' $selected>" . htmlspecialchars($type['nome']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <?php if ($ehDono): ?>
                <button type="submit" class="btn btn-primary w-100"><?php echo $pokemon ? "Salvar Alterações" : "Criar Pokémon"; ?></button>
            <?php else: ?>
                <p class="text-danger fw-bold text-center">Você não tem permissão para editar este Pokémon.</p>
            <?php endif; ?>
        </form>

        <a href="home.php" class="btn btn-outline-secondary mt-3 w-100">Voltar</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script>
        const selectTypes = document.querySelector('select[name="types[]"]');
        selectTypes.addEventListener('change', () => {
            const selectedOptions = Array.from(selectTypes.selectedOptions);
            if (selectedOptions.length > 2) {
                selectedOptions[selectedOptions.length - 1].selected = false;
                alert('Selecione no máximo 2 tipos.');
            }
        });
    </script>
</body>

</html>
