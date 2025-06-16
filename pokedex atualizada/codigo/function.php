<?php
function criarUsuario($conexao, $email, $senha, $Tipo ) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuario (email, senha, Tipo) VALUES (?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'sss', $email, $senha_hash, $Tipo);
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    return $funcionou;
}

function editarUsuario($conexao, $email, $senha, $idusuario) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE usuario SET email=?, senha=? WHERE idusuario=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'ssi', $email, $senha_hash, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}

#=================================================================================================================

function criarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario) {
    $sql = "INSERT INTO perfil (nome, pokemon_fav, descricao, idusuario) VALUES (?, ?, ?, ?)";
    $comando = mysqli_prepare ($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sssi', $nome, $pokemon_fav, $descricao, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}



function editarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario, $id) {
        $sql = "UPDATE perfil SET nome=?, pokemon_fav=?, descricao=?, idusuario=? WHERE id=?";
        $comando = mysqli_prepare($conexao, $sql);
    
        mysqli_stmt_bind_param($comando, 'sssii', $nome, $pokemnon_fav, $descricao, $idusuario, $id);
        $funcionou = mysqli_stmt_execute($comando);
    
        mysqli_stmt_close($comando);
        return $funcionou;
    }
#=================================================================================================================

function criarPokemon ($conexao, $national, $nome, $gen) {
    $sql = "INSERT INTO pokemon (national, nome, gen) VALUES (?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'isi', $national, $nome, $gen);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;

}



function criarStats($conexao, $idpokemon, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed) {
    $sql = "INSERT INTO stats (idpokemon, hp, attack, defense, sp_attack, sp_defense, speed) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'iiiiiii', $idpokemon, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}



function editarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $id) {
    $sql = "UPDATE stats SET hp=?, attack=?, defense=?, sp_attack=?, sp_defense=?, speed=? WHERE idstats=?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'iiiiiii', $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $id);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou; 

}



function listarStats ($conexao, ) {
    $sql = "SELECT * FROM stats";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);
    
    while ($lista = mysqli_fetch_assoc($resultados)) {
        $idpokemon = $lista['idpokemon'];
        $pokemon = pesquisarPokemonId($conexao, $idpokemon);
        $lista['nomepokemon'] = $pokemon['nome'];
        

        $lista_st[] = $lista;

    }
    mysqli_stmt_close($comando);

    return $lista_st;
}

function deletarStats($conexao, $idstats) {
    $sql = "DELETE FROM stats WHERE idstats = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idstats);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

function editarPokemon($conexao, $national, $nome, $gen, $id) {
    $sql = "UPDATE pokemon SET national=?, nome=?, gen=? WHERE idpokemon=?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'isii', $national, $nome, $gen, $id);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou; 

}



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

function deletarPokemon($conexao, $idpokemon) {
    $sql = "DELETE FROM pokemon WHERE idpokemon = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

function criarBuild($conexao, $nome, $idpokemon) {
    $sql = "INSERT INTO build (nome, idpokemon) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'si', $nome, $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);

    return $funcionou;

}

function editarBuild($conexao, $nome, $idpokemon, $id) {
    $sql = "UPDATE build SET nome=?, idpokemon=? WHERE idbuild=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sii', $nome, $idpokemon, $id); 
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}



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

function deletarBuild($conexao, $idbuild) {
    $sql = "DELETE FROM build WHERE idbuild = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idbuild);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

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

function listarTypes($conexao) {
    $sql = "SELECT * FROM types";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);
    
    $lista_typos = [];
    while ($types = mysqli_fetch_assoc($resultados)) {
        $lista_typos[] = $types;
    }
    mysqli_stmt_close($comando);

    return $lista_typos;

}

function deletartypes($conexao, $idtypes) {
    $sql = "DELETE FROM types WHERE idtypes = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idtypes);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

#=================================================================================================================

function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao, $idusuario) {
        $sql = "INSERT INTO suporte (reclamacao, sugestao, idusuario) VALUES (?, ?, ?)";
        $comando = mysqli_prepare($conexao, $sql);
    
        mysqli_stmt_bind_param($comando, 'ssi', $reclamacao, $sugestao, $idusuario);
    
        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);
    
        return $funcionou;
    
    }

function listarSugestao_reclamacao($conexao) {
        $sql = "SELECT * FROM suporte";
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

function deletarSugestao_reclamacao($conexao, $idsuporte) {
        $sql = "DELETE FROM suporte WHERE idsuporte = ?";
        $comando = mysqli_prepare($conexao, $sql);
        
        mysqli_stmt_bind_param($comando, 'i', $idsuporte);
    
        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);
        
        return $funcionou;
}

function criarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon) {
    $sql = "INSERT INTO treinador (nome, idade, genero, cidade, regiao, time_atual, data_cadastro, idpokemon) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sisssssi', $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);

    return $funcionou;

}

function editarTreinador($conexao, $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id) {
     $sql = "UPDATE treinador SET nome=?, idade=?, genero=?, cidade=?, regiao=?, time_atual=?, data_cadastro=?, idpokemon=? WHERE idpokemon=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sisssssii', $nome, $idade, $genero, $cidade, $regiao, $time_atual, $data_cadastro, $idpokemon, $id);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}

function listarTreinador($conexao) {
    $sql = "SELECT * FROM treinador";
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

function deletarTreinador($conexao, $idtreinador) {
    $sql = "DELETE FROM treinador WHERE idtreinador = ?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'i', $idtreinador);

    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}

?>