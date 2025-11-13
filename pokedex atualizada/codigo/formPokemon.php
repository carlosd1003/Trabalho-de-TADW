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
    $pokemon = pegarPokemonPorId($conexao, $idpokemon);
    $stats = pegarStatsPorPokemon($conexao, $idpokemon);
    $types_do_pokemon = buscarTypesDoPokemon($conexao, $idpokemon);

    if ($pokemon and $pokemon['usuario_idusuario'] == $usuario_idusuario) {
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
    <!-- jQuery (carrega primeiro) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery Validate (depois do jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script>
        $(function() {
    const $form = $('#formulario');
    const isEdit = $('input[name="idpokemon"]').length > 0;  // Verifica se estamos em modo de edição

    // Condiciona a validação
    $('#formulario').validate({
        ignore: [],  // Não ignorar campos ocultos, selects, etc.
        rules: {
            nome: {
                required: true,
                minlength: 3
            },
            gen: {
                required: true,
                number: true,
                min: 1
            },
            hp: {
                required: true,
                number: true,
                min: 1
            },
            attack: {
                required: true,
                number: true,
                min: 1
            },
            defense: {
                required: true,
                number: true,
                min: 1
            },
            spattack: {
                required: true,
                number: true,
                min: 1
            },
            spdefense: {
                required: true,
                number: true,
                min: 1
            },
            speed: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            national: {
                required: "Esse campo não pode ser vazio",
                digits: "Informe um número inteiro válido",
                remote: "O valor precisa ser exatamente o próximo disponível."
            },
            nome: {
                required: "Esse campo não pode ser vazio",
                minlength: "Esse campo tem que ter mais de 3 caracteres"
            },
            gen: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            hp: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            attack: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            defense: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            spattack: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            spdefense: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            },
            speed: {
                required: "Esse campo não pode ser vazio",
                number: "Informe um número válido",
                min: "O número precisa ser maior que 0"
            }
        },
                // Estilinho do Bootstrap
                highlight: function(el) {
                    // Quando o campo for inválido, adiciona a classe 'is-invalid'
                    // e remove a classe 'is-valid' (para mudar o estilo visual conforme o Bootstrap)
                    el.classList.add('is-invalid');
                    el.classList.remove('is-valid');
                },
                unhighlight: function(el) {
                    // Quando o campo for válido, remove 'is-invalid'
                    // e adiciona 'is-valid' para mostrar o campo com aparência correta
                    el.classList.remove('is-invalid');
                    el.classList.add('is-valid');
                },
                errorElement: 'div',
                // Define que as mensagens de erro serão colocadas dentro de uma <div>

                errorClass: 'invalid-feedback',
                // Define a classe CSS usada nas mensagens de erro (Bootstrap usa essa para estilizar)

                errorPlacement: function(error, element) {
                    // Define onde a mensagem de erro será exibida no HTML

                    if (element.parent('.input-group').length) {
                        // Se o campo estiver dentro de um grupo de inputs (como ícones ou botões),
                        // insere o erro logo depois do grupo inteiro
                        error.insertAfter(element.parent());
                    } else {
                        // Caso contrário, insere o erro logo depois do campo de formulário
                        error.insertAfter(element);
                    }
                }
    });

    // Condicionando a validação de tipos (permitir mais de 2 tipos somente se em edição)
    const selectTypes = document.querySelector('select[name="types[]"]');
    if (!isEdit) {
        selectTypes.addEventListener('change', () => {
            const selectedOptions = Array.from(selectTypes.selectedOptions);
            if (selectedOptions.length > 2) {
                selectedOptions[selectedOptions.length - 1].selected = false;
                alert('Selecione no máximo 2 tipos.');
            }
        });
    }

    // Submissão do formulário
    $form.on('submit', function(e) {
        if (!$form.valid()) {
            e.preventDefault();
            return false; // Impede o envio se o formulário não for válido
        }
    });
});

    </script>


</head>
<!-- O "?" preenche o input com o nome do Pokémon se $pokemon existir; caso contrário, deixa vazio -->


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
                <?php if ($pokemon and $pokemon['imagem']): ?>
                    <div class="mt-2">
                        <img src="fotos/<?php echo htmlspecialchars($pokemon['imagem']); ?>" alt="Imagem do Pokémon" width="80" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="hp" class="form-label">HP:</label>
                <input type="number" id="hp" name="hp" class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['hp']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="attack" class="form-label">Attack:</label>
                <input type="number" id="attack" name="attack" class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['attack']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="defense" class="form-label">Defense:</label>
                <input type="number" id="defense" name="defense" class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['defense']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="spattack" class="form-label">Special Attack:</label>
                <input type="number" id="spattack" name="spattack" class="form-control"
                    value="<?php echo $stats ? htmlspecialchars($stats['sp_attack']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="spdefense" class="form-label">Special Defense:</label>
                <input type="number" id="spdefense" name="spdefense" class="form-control"
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

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formulario');
    const nationalInput = document.getElementById('national');

    // Se existir o hidden idpokemon, estamos editando (não travar o número)
    const isEdit = !!document.querySelector('input[name="idpokemon"]');

    // Cria/usa um aviso visual abaixo do campo
    let hint = document.getElementById('national-help');
    if (!hint) {
        hint = document.createElement('div');
        hint.id = 'national-help';
        hint.className = 'form-text';
        nationalInput.insertAdjacentElement('afterend', hint);
    }

    let maxId = null; // maior já existente no BD

    async function fetchMaxId() {
        try {
            const r = await fetch('obter_max_id.php', {
                cache: 'no-store'
            });
            const data = await r.json();
            maxId = Number(data.maxId) || 0;
            renderHint();
        } catch (e) {
            console.error('Falha ao obter maxId:', e);
            // fallback: considera 0
            maxId = 0;
            renderHint();
        }
    }

    function renderHint() {
        if (isEdit) {
            hint.textContent = '';
            nationalInput.classList.remove('is-invalid', 'is-valid');
            return;
        }
        const nextId = maxId + 1;
        hint.textContent = `Último criado: ${maxId}. O próximo permitido é exatamente: ${nextId}.`;
        validateNow();
    }

    function validateNow() {
        if (isEdit) return; // não valida em edição

        const val = Number(nationalInput.value);
        const nextId = maxId + 1;

        if (!Number.isInteger(val)) {
            nationalInput.setCustomValidity('Digite um número inteiro válido.');
            nationalInput.classList.add('is-invalid');
            nationalInput.classList.remove('is-valid');
            return false;
        }

        if (val !== nextId) {
            // Se digitou menor ou maior, travar e mostrar a dica
            nationalInput.setCustomValidity(`O valor precisa ser exatamente ${nextId}.`);
            nationalInput.classList.add('is-invalid');
            nationalInput.classList.remove('is-valid');
            return false;
        }

        // ok
        nationalInput.setCustomValidity('');
        nationalInput.classList.remove('is-invalid');
        nationalInput.classList.add('is-valid');
        return true;
    }

    // Quando o usuário digitar, validar e informar
    nationalInput.addEventListener('input', () => {
        // Se digitou menor que o existente, destacar e “mostrar o já existente”
        if (!isEdit && maxId !== null) {
            const val = Number(nationalInput.value);
            if (Number.isInteger(val) && val <= maxId) {
                hint.textContent = `⚠️ Você digitou ${val}, mas o último já existente é ${maxId}. O próximo permitido é ${maxId + 1}.`;
            } else {
                // volta para o hint padrão
                renderHint();
            }
        }
        validateNow();
    });

    // Impedir envio se não for exatamente o próximo permitido
    form.addEventListener('submit', (e) => {
        if (isEdit) return; // em edição, deixa enviar
        if (maxId === null) { 
            // Se ainda não carregou maxId, bloqueia o envio
            e.preventDefault();
            alert('Aguarde o carregamento dos dados antes de enviar.');
            return;
        }
        if (!validateNow()) {
            e.preventDefault();
            nationalInput.reportValidity(); // mostra o balão nativo
            nationalInput.focus();
        }
    });

    // Carrega o maxId ao abrir
    fetchMaxId();
});

    </script>
    </body>

</html>