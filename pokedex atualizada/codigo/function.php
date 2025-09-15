<?php
/**
 * Cria um novo usuário no sistema
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $email Email do usuário
 * @param string $senha Senha do usuário (será convertida para hash)
 * @param string $Tipo Tipo de usuário (ex: 'admin', 'usuario')
 * @return bool True se criado com sucesso, False caso contrário
 */
function criarUsuario($conexao, $email, $senha, $Tipo ) { #cria um novo usuário no sistema
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuario (email, senha, Tipo) VALUES (?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);#
    mysqli_stmt_bind_param($comando, 'sss', $email, $senha_hash, $Tipo);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
}

#=================================================================================================================
/**
 * Cria um perfil de usuário
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do perfil
 * @param string $pokemon_fav Pokémon favorito
 * @param string $descricao Descrição do perfil
 * @param int $idusuario ID do usuário associado
 * @return bool True se criado com sucesso, False caso contrário
 */

function criarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario) {
    $sql = "INSERT INTO perfil (nome, pokemon_fav, descricao, idusuario) VALUES (?, ?, ?, ?)";
    $comando = mysqli_prepare ($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sssi', $nome, $pokemon_fav, $descricao, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}

/**
 * Edita um perfil existente
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do perfil
 * @param string $pokemon_fav Pokémon favorito
 * @param string $descricao Descrição do perfil
 * @param int $idusuario ID do usuário associado
 * @param int $id ID do perfil a ser editado
 * @return bool True se editado com sucesso, False caso contrário
 */
function editarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario, $id) {
        $sql = "UPDATE perfil SET nome=?, pokemon_fav=?, descricao=?, idusuario=? WHERE id=?";
        $comando = mysqli_prepare($conexao, $sql);
    
        mysqli_stmt_bind_param($comando, 'sssii', $nome, $pokemon_fav, $descricao, $idusuario, $id);
        $funcionou = mysqli_stmt_execute($comando);
    
        mysqli_stmt_close($comando);
        return $funcionou;
    }

/**
 * Deleta um perfil
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $idperfil ID do perfil a ser deletado
 * @return bool True se deletado com sucesso, False caso contrário
 */
function deletarPerfil($conexao, $idperfil) {
    $sql = "DELETE FROM perfil WHERE idperfil = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idperfil);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
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
function editarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $id) {
    $sql = "UPDATE stats SET hp=?, attack=?, defense=?, sp_attack=?, sp_defense=?, speed=? WHERE idstats=?";
    $comando = mysqli_prepare($conexao, $sql);
   
    mysqli_stmt_bind_param($comando, 'iiiiiii', $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $id);
    $funcionou = mysqli_stmt_execute($comando);
   
    mysqli_stmt_close($comando);
    return $funcionou; 
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
function deletarStats($conexao, $idstats) {
    $sql = "DELETE FROM stats WHERE idstats = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idstats);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================
/**
 * Cria um novo Pokémon
 * @param mysqli $conexao Conexão com o banco de dados
 * @param int $national Número nacional do Pokémon
 * @param string $nome Nome do Pokémon
 * @param int $gen Geração do Pokémon
 * @param string $imagem URL ou caminho da imagem
 * @param int $idusuario ID do usuário que criou
 * @return bool True se criado com sucesso, False caso contrário
 */
function criarPokemon($conexao, $national, $nome, $gen, $imagem, $idusuario) {
    $sql = "INSERT INTO pokemon (national, nome, gen, imagem, idusuario) VALUES (?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'isisi', $national, $nome, $gen, $imagem, $idusuario);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
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
function editarPokemon($conexao, $national, $nome, $gen, $id) {
    $sql = "UPDATE pokemon SET national=?, nome=?, gen=? WHERE idpokemon=?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'isii', $national, $nome, $gen, $id);
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
        $build['NomeDoPokemon'] = $pokemon['nome'];

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
function pesquisarBuild($conexao, $idbuild) {
    $sql = "SELECT * FROM build WHERE idbuild = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'i', $idbuild);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $build = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $build;

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
    // Garante que seja um array
    if (!is_array($types)) {
        $types = [$types];
    }

    foreach ($types as $idtype) {
        $idtype = (int)$idtype; // segurança
        $sql = "INSERT INTO pokemon_has_types (idpokemon, idtypes) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $idpokemon, $idtype);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

/**
 * Pesquisa tipo por nome
 * @param mysqli $conexao Conexão com o banco de dados
 * @param string $nome Nome do tipo
 * @return array|null Dados do tipo ou null se não encontrado
 */
function pesquisarTypes($conexao, $nome) {
    $sql = "SELECT * FROM types WHERE nome = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 's', $nome);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $types = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $types;

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
function deletartypes($conexao, $idtypes) {
    $sql = "DELETE FROM types WHERE idtypes = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idtypes);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
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
function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario) {
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
    $sql = "SELECT * FROM treinador WHERE nome = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 's', $nome);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $treinador = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $treinador;

}
?>