<?php
/**
 * Cria um novo usuário no sistema
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $email Email do usuário
 * @param string $senha Senha do usuário (será convertida para hash)
 * @param string $Tipo Tipo de usuário (ex: 'admin', 'usuario')
 * @return bool True se criado com sucesso, False caso contrário
 */
function criarUsuario($conexao, $nome, $email, $senha, $Tipo, $pokemon_fav = NULL, $descricao = NULL) {
    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // SQL para inserir o novo usuário
    $sql = "INSERT INTO usuario (nome, email, senha, Tipo, pokemon_fav, descricao) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepara a consulta
    $comando = mysqli_prepare($conexao, $sql);

    if (!$comando) {
        // Se não conseguir preparar a query, retorna falso
        return false;
    }

    // Vincula os parâmetros ao comando preparado
    mysqli_stmt_bind_param($comando, 'ssssss', $nome, $email, $senha_hash, $Tipo, $pokemon_fav, $descricao);

    // Executa o comando
    $funcionou = mysqli_stmt_execute($comando);

    // Fecha a consulta
    mysqli_stmt_close($comando);

    // Retorna se a execução foi bem-sucedida
    return $funcionou;
}

function pesquisarUsuarioId($conexao, $idusuario) {
    $sql = "SELECT * FROM usuario WHERE idusuario = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idusuario);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $usuario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $usuario;

}

#=================================================================================================================

/**
 * Cria estatísticas para um Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon
 * @param int $hp Pontos de vida
 * @param int $attack Ataque
 * @param int $defense Defesa
 * @param int $sp_attack Ataque especial
 * @param int $sp_defense Defesa especial
 * @param int $speed Velocidade
 * @return bool True se criado com sucesso, False caso contrário
 */
function criarStats($conexao, $idpokemon, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed) {
    $sql = "INSERT INTO stats (idpokemon, hp, attack, defense, sp_attack, sp_defense, speed) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'iiiiiii', $idpokemon, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

/**
 * Edita estatísticas existentes
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $hp Pontos de vida
 * @param int $attack Ataque
 * @param int $defense Defesa
 * @param int $sp_attack Ataque especial
 * @param int $sp_defense Defesa especial
 * @param int $speed Velocidade
 * @param int $id ID das estatísticas a editar
 * @return bool True se editado com sucesso, False caso contrário
 */
function editarStats($conexao, $idpokemon, $hp, $attack, $defense, $spattack, $spdefense, $speed) {
    $sql = "UPDATE stats SET 
                hp = ?, 
                attack = ?, 
                defense = ?, 
                sp_attack = ?, 
                sp_defense = ?, 
                speed = ? 
            WHERE idpokemon = ?";
    
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'iiiiiii', $hp, $attack, $defense, $spattack, $spdefense, $speed, $idpokemon);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $ok;
}
    

/**
 * Lista todas as estatísticas com nome do Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de estatísticas com informações do Pokémon
 */

function listarStats ($conexao) {
    $sql = "SELECT * FROM stats";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $lista_st = []; // Inicialização aqui evita o erro

    while ($lista = mysqli_fetch_assoc($resultados)) {
        $idpokemon = $lista['idpokemon'];
        $pokemon = pesquisarPokemonId($conexao, $idpokemon);
        $lista['nomepokemon'] = $pokemon['nome'];

        $lista_st[] = $lista;
    }

    mysqli_stmt_close($comando);

    return $lista_st;
}

/**
 * Deleta estatísticas
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idstats ID das estatísticas a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarStats($conexao, $idpokemon) {
    $sql = "DELETE FROM stats WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

/**
 * Insere um novo Pokémon no banco de dados
 *
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $national Número da Pokédex Nacional
 * @param string $nome Nome do Pokémon
 * @param int $gen Geração do Pokémon
 * @param string $imagem Caminho ou URL da imagem do Pokémon
 * @param int $usuario_idusuario ID do usuário dono do Pokémon
 * @return bool Retorna true se a inserção for bem-sucedida, false caso contrário
 */
function criarPokemon($conexao, $national, $nome, $gen, $imagem, $usuario_idusuario) {
    $sql = "INSERT INTO pokemon (national, nome, gen, imagem, usuario_idusuario) VALUES (?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'isisi', $national, $nome, $gen, $imagem, $usuario_idusuario);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

function pegarPokemonPorId($conexao, $idpokemon) {
    $sql = "SELECT * FROM pokemon WHERE idpokemon = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idpokemon);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $pokemon = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);
    return $pokemon; // Retorna um array associativo com os dados do Pokémon
}

function pegarStatsPorPokemon($conexao, $idpokemon) {
    $sql = "SELECT * FROM stats WHERE idpokemon = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idpokemon);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $stats = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);
    return $stats; // Retorna um array associativo com os stats do Pokémon
}



function pesquisarPokemonPorTipo($conexao, $tipo) {
    $sql = "SELECT p.*
            FROM pokemon p
            JOIN pokemon_has_types pht ON p.idpokemon = pht.idpokemon
            JOIN types t ON pht.idtypes = t.idtypes
            WHERE t.nome LIKE ?";

    $tipoParam = '%' . $tipo . '%';
    $stmt = mysqli_prepare($conexao, $sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, "s", $tipoParam);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $pokemons = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $pokemons[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $pokemons;
}


function pesquisarPokemonPorNomeETipo($conexao, $nome, $tipo) {
    $sql = "SELECT DISTINCT p.*
            FROM pokemon p
            JOIN pokemon_has_types pht ON p.idpokemon = pht.idpokemon
            JOIN types t ON pht.idtypes = t.idtypes
            WHERE p.nome LIKE ? AND t.nome LIKE ?";

    $nomeParam = '%' . $nome . '%';
    $tipoParam = '%' . $tipo . '%';

    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação: " . $conexao->error);
    }

    $stmt->bind_param("ss", $nomeParam, $tipoParam);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $pokemons = [];
    while ($row = $resultado->fetch_assoc()) {
        $pokemons[] = $row;
    }

    $stmt->close();
    return $pokemons;
}







/**
 * Pesquisa Pokémon incluindo informações do dono
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon
 * @return array|null Dados do Pokémon ou null se não encontrado
 */
function pesquisarPokemonComDono($conexao, $idpokemon) {
    $sql = "SELECT * FROM pokemon WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idpokemon);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $pokemon = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($comando);

    return $pokemon;
}


/**
 * Verifica se número nacional já existe
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $national Número nacional a verificar
 * @return bool True se existe, False caso contrário
 */
/**
 * Lista todos os números nacionais existentes
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de números nacionais
 */
function nationalExiste($conexao, $national) {
    $sql = "SELECT idpokemon FROM pokemon WHERE national = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $national);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $existe = mysqli_stmt_num_rows($stmt) > 0;

    mysqli_stmt_close($stmt);
    return $existe;
}


function listarNationals($conexao) {
    $sql = "SELECT national FROM pokemon";
    $result = mysqli_query($conexao, $sql);
    $nationals = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $nationals[] = (int)$row['national'];
    }
    return $nationals;
}

/**
 * Obtém o maior número nacional cadastrado
 * @param mysqli $conexao Conexão com o banco de dados
 * @return int Maior número nacional ou 0 se não houver registros
 */
function pegarMaiorNational($conexao) {
    $sql = "SELECT MAX(national) AS maior FROM pokemon";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row ? (int)$row['maior'] : 0;
}

/**
 * Edita informações de um Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $national Número nacional
 * @param string $nome Nome do Pokémon
 * @param int $gen Geração
 * @param int $id ID do Pokémon a editar
 * @return bool True se editado com sucesso, False caso contrário
 */
function editarPokemon($conexao, $national, $nome, $gen, $idpokemon, $imagem = null) {
    if ($imagem) {
        // Atualiza TUDO, incluindo a imagem
        $sql = "UPDATE pokemon SET national = ?, nome = ?, gen = ?, imagem = ? WHERE idpokemon = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, 'isisi', $national, $nome, $gen, $imagem, $idpokemon);
    } else {
        // Atualiza sem alterar a imagem
        $sql = "UPDATE pokemon SET national = ?, nome = ?, gen = ? WHERE idpokemon = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, 'isii', $national, $nome, $gen, $idpokemon);
    }

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

/**
 * Lista todos os Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de Pokémon
 */
function listarPokemon($conexao) {
    $sql = "SELECT * FROM pokemon";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);
    
    $lista_pokemon = [];
    while ($pokemon = mysqli_fetch_assoc($resultados)) {
        $lista_pokemon[] = $pokemon;
    }
    mysqli_stmt_close($comando);

    return $lista_pokemon;

}

/**
 * Pesquisa Pokémon por ID
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon
 * @return array|null Dados do Pokémon ou null se não encontrado
 */
function pesquisarPokemonId($conexao, $idpokemon) {
    $sql = "SELECT * FROM pokemon WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idpokemon);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $pokemon = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $pokemon;

}



function pesquisarPokemonNome($conexao, $nome)
{
    $sql = "SELECT * FROM pokemon WHERE nome LIKE ?";
    $comando = mysqli_prepare($conexao, $sql);

    $nome = "%" . $nome . "%";
    mysqli_stmt_bind_param($comando, 's', $nome);

    mysqli_stmt_execute($comando);

    $resultados = mysqli_stmt_get_result($comando);

    $lista_pokemons = [];
    while ($pokemon = mysqli_fetch_assoc($resultados)) {
        $lista_pokemons[] = $pokemon;
    }
    mysqli_stmt_close($comando);

    return $lista_pokemons;
}




/**
 * Deleta um Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarPokemon($conexao, $idpokemon) {
    $sql = "DELETE FROM pokemon WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

/**
 * Cria uma nova build
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome da build
 * @param int $idpokemon ID do Pokémon associado
 * @return bool True se criado com sucesso, False caso contrário
 */

function criarBuild($conexao, $nome, $idpokemon) {
    $sql = "INSERT INTO build (nome, idpokemon) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $nome, $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);

    return $funcionou;

}

/**
 * Edita uma build existente
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome da build
 * @param int $idpokemon ID do Pokémon associado
 * @param int $id ID da build a editar
 * @return bool True se editado com sucesso, False caso contrário
 */
function editarBuild($conexao, $nome, $idpokemon, $id) {
    $sql = "UPDATE build SET nome=?, idpokemon=? WHERE idbuild=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sii', $nome, $idpokemon, $id); 
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}

/**
 * Lista todas as builds com nome do Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de builds com informações do Pokémon
 */
function listarBuild($conexao) {
    $sql = "SELECT * FROM build";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $lista_build = [];
    while ($build = mysqli_fetch_assoc($resultados)) {
        $idpokemon = $build['idpokemon'];
        $pokemon = pesquisarPokemonId($conexao, $idpokemon);
        $build['pokemon_nome'] = $pokemon['nome'];

        $lista_build[] = $build;
    }

    mysqli_stmt_close($comando);
    return $lista_build;
}

/**
 * Pesquisa build por ID
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idbuild ID da build
 * @return array|null Dados da build ou null se não encontrada
 */
function pesquisarBuild($conexao, $nome) {
    $sql = "SELECT build.idbuild,
                build.nome,
                pokemon.nome AS pokemon_nome
            FROM build
            JOIN pokemon ON build.idpokemon = pokemon.idpokemon
            WHERE build.nome LIKE ?";
    $comando = mysqli_prepare($conexao, $sql);

    $nome = "%" . $nome . "%";
    
    mysqli_stmt_bind_param($comando, 's', $nome);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_builds = [];
    while ($build = mysqli_fetch_assoc($resultado)) {
        $lista_builds[] = $build;
    }

    mysqli_stmt_close($comando);

    return $lista_builds;
}


/**
 * Deleta uma build
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idbuild ID da build a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarBuild($conexao, $idbuild) {
    $sql = "DELETE FROM build WHERE idbuild = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idbuild);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

/**
 * Associa tipos a um Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon
 * @param array|int $types ID(s) do(s) tipo(s) a associar
 * @return void
 */
function salvarTypes($conexao, $idpokemon, $types) {
    // Primeiro, remove os tipos antigos do Pokémon
    $sqlDelete = "DELETE FROM pokemon_has_types WHERE idpokemon = ?";
    $stmtDelete = mysqli_prepare($conexao, $sqlDelete);
    mysqli_stmt_bind_param($stmtDelete, 'i', $idpokemon);
    mysqli_stmt_execute($stmtDelete);
    mysqli_stmt_close($stmtDelete);

    // Garante que $types seja um array
    if (!is_array($types)) {
        $types = [$types];
    }

    // Insere os novos tipos
    foreach ($types as $idtype) {
        $idtype = (int)$idtype; // segurança
        $sqlInsert = "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES (?, ?)";
        $stmtInsert = mysqli_prepare($conexao, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, 'ii', $idpokemon, $idtype);
        mysqli_stmt_execute($stmtInsert);
        mysqli_stmt_close($stmtInsert);
    }
}

/**
 * Pesquisa tipo por nome
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do tipo
 * @return array|null Dados do tipo ou null se não encontrado
 */
function pesquisarTypesNome($conexao, $nome) {
    $sql = "SELECT * FROM types WHERE nome LIKE ?";
    $comando = mysqli_prepare($conexao, $sql);

    $nomeParam = "%" . $nome . "%";
    mysqli_stmt_bind_param($comando, 's', $nomeParam);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_types = [];
    while ($type = mysqli_fetch_assoc($resultado)) {
        $lista_types[] = $type;
    }

    mysqli_stmt_close($comando);
    return $lista_types;
}


/**
 * Busca tipos associados a um Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idpokemon ID do Pokémon
 * @return array Lista de nomes dos tipos
 */
function buscarTypesDoPokemon($conexao, $idpokemon) {
    $sql = "SELECT t.nome
            FROM types t
            JOIN pokemon_has_types pht ON pht.idtypes = t.idtypes
            WHERE pht.idpokemon = ?";
    
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conexao->error);
    }
    
    $stmt->bind_param("i", $idpokemon);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $types = [];
    while ($row = $resultado->fetch_assoc()) {
        $types[] = $row['nome'];
    }
    
    $stmt->close();
    return $types;
}

/**
 * Lista todos os tipos disponíveis
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de tipos com ID e nome
 */
function listarTypes($conexao) {
    $sql = "SELECT idtypes, nome FROM types";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    mysqli_stmt_bind_result($comando, $idtypes, $nome);

    $lista_typos = [];

    while (mysqli_stmt_fetch($comando)) {
        $lista_typos[] = [
            'idtypes' => $idtypes,
            'nome' => $nome
        ];
    }

    mysqli_stmt_close($comando);

    return $lista_typos;
}

/**
 * Deleta um tipo
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idtypes ID do tipo a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarTypes($conexao, $idpokemon) {
    $sql = "DELETE FROM pokemon_has_types WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $idpokemon);
    mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
}


#=================================================================================================================

/**
 * Cria uma sugestão ou reclamação
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $reclamacao Texto da reclamação
 * @param string $sugestao Texto da sugestão
 * @param int $idusuario ID do usuário que enviou
 * @return bool True se criado com sucesso, False caso contrário
 */
function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $email) {
    // 1. Buscar o idusuario a partir do email
    $sql_usuario = "SELECT idusuario FROM usuario WHERE email = ?";
    $comando_usuario = mysqli_prepare($conexao, $sql_usuario);
    mysqli_stmt_bind_param($comando_usuario, 's', $email);
    mysqli_stmt_execute($comando_usuario);
    mysqli_stmt_bind_result($comando_usuario, $idusuario);
    mysqli_stmt_fetch($comando_usuario);
    mysqli_stmt_close($comando_usuario);

    // Se não encontrar o email, retorna falso
    if (!$idusuario) {
        return false;
    }

    // 2. Inserir a reclamação e sugestão na tabela suporte
    $sql = "INSERT INTO suporte (reclamacao, sugestao, idusuario) VALUES (?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'ssi', $reclamacao, $sugestao, $idusuario);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);

    return $funcionou;
}


    /**
 * Lista todas as sugestões/reclamações com email do usuário
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de registros de suporte
 */
function listarSugestao_reclamacao($conexao) {
        $sql = "SELECT 
                suporte.idsuporte, 
                suporte.reclamacao, 
                suporte.sugestao, 
                usuario.email AS email_usuario
            FROM suporte
            JOIN usuario ON suporte.idusuario = usuario.idusuario";
        $comando = mysqli_prepare($conexao, $sql);
        
        mysqli_stmt_execute($comando);
        $resultados = mysqli_stmt_get_result($comando);
        
        $lista_suporte = [];
        while ($suporte = mysqli_fetch_assoc($resultados)) {
            $lista_suporte[] = $suporte;
        }
        mysqli_stmt_close($comando);
    
        return $lista_suporte;
    
    }
   
    /**
 * Deleta um registro de suporte
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idsuporte ID do registro a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarSugestao_reclamacao($conexao, $idsuporte) {
        $sql = "DELETE FROM suporte WHERE idsuporte = ?";
        $comando = mysqli_prepare($conexao, $sql);
        
        mysqli_stmt_bind_param($comando, 'i', $idsuporte);
    
        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);
        
        return $funcionou;
}

/**
 * Pesquisa sugestões/reclamações por usuário
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idusuario ID do usuário
 * @return array|null Dados do registro ou null se não encontrado
 */
function pesquisarSugestao_reclamacao($conexao, $idusuario) {
    $sql = "SELECT * FROM suporte WHERE idusuario = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idusuario);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $suporte = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $suporte;

}

#=================================================================================================================

/**
 * Cria um novo treinador
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do treinador
 * @param int $idade Idade do treinador
 * @param string $genero Gênero do treinador
 * @param string $cidade Cidade do treinador
 * @param string $regiao Região do treinador
 * @param string $time_atual Time atual do treinador
 * @param string $data_cadastro Data de cadastro (formato string)
 * @param int $idpokemon ID do Pokémon associado
 * @return bool True se criado com sucesso, False caso contrário
 */
function criarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon) {
    $sql = "INSERT INTO treinador (nome, idade, genero, cidade, regiao, time_atual, data_cadastro, idpokemon) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sisssssi', $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);

    return $funcionou;

}


/**
 * Edita um treinador existente
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do treinador
 * @param int $idade Idade do treinador
 * @param string $genero Gênero do treinador
 * @param string $cidade Cidade do treinador
 * @param string $regiao Região do treinador
 * @param string $time_atual Time atual do treinador
 * @param string $data_cadastro Data de cadastro
 * @param int $idpokemon ID do Pokémon associado
 * @param int $id ID do treinador a editar
 * @return bool True se editado com sucesso, False caso contrário
 */
function editarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id) {
     $sql = "UPDATE treinador SET nome=?, idade=?, genero=?, cidade=?, regiao=?, time_atual=?, data_cadastro=?, idpokemon=? WHERE idtreinador=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sisssssii', $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}

/**
 * Lista todos os treinadores com nome do Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @return array Lista de treinadores
 */
function listarTreinador($conexao) {
    $sql = "SELECT idtreinador, treinador.nome, treinador.idade, treinador.genero, treinador.cidade, 
            treinador.regiao, treinador.time_atual, treinador.data_cadastro, pokemon.nome 
            AS pokemon_nome
            FROM treinador
            JOIN pokemon ON treinador.idpokemon = pokemon.idpokemon";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);
    
    $lista_treinador = [];
    while ($treinador = mysqli_fetch_assoc($resultados)) {
        $lista_treinador[] = $treinador;
    }
    mysqli_stmt_close($comando);

    return $lista_treinador;

}

/**
 * Deleta um treinador
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idtreinador ID do treinador a deletar
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarTreinador($conexao, $idtreinador) {
    $sql = "DELETE FROM treinador WHERE idtreinador = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idtreinador);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

/**
 * Pesquisa treinador por nome
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do treinador
 * @return array|null Dados do treinador ou null se não encontrado
 */
function pesquisarTreinador($conexao, $nome) {
    // Usar LIKE para permitir pesquisa por nomes parciais
    $sql = "SELECT 
                treinador.idtreinador,
                treinador.nome,
                treinador.idade,
                treinador.genero,
                treinador.cidade,
                treinador.regiao,
                treinador.time_atual,
                treinador.data_cadastro,
                pokemon.nome AS pokemon_nome
            FROM treinador
            JOIN pokemon ON treinador.idpokemon = pokemon.idpokemon
            WHERE treinador.nome LIKE ?";
    $comando = mysqli_prepare($conexao, $sql);

    $nome = "%" . $nome . "%";
    
    mysqli_stmt_bind_param($comando, 's', $nome);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $lista_treinadores = [];
    while ($treinador = mysqli_fetch_assoc($resultado)) {
        $lista_treinadores[] = $treinador;
    }

    mysqli_stmt_close($comando);

    return $lista_treinadores;
}

?>