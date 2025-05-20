<?php
    function criarUsuario($conexao, $email, $senha, ) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (email, senha) VALUES (?, ?)";
        $comando = mysqli_prepare($conexao, $sql);

        mysqli_stmt_bind_param($comando, 'ss', $email, $senha_hash);

        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);

        return $funcionou;
    }



    function editarUsuario($conexao, $email, $senha, $id) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET email=?, senha=? WHERE id=?";
        $comando = mysqli_prepare($conexao, $sql);
    
        mysqli_stmt_bind_param($comando, 'ssi', $email, $senha_hash, $id);
        $funcionou = mysqli_stmt_execute($comando);
    
        mysqli_stmt_close($comando);
        return $funcionou;
    }



#=================================================================================================================

function criarPerfil($conexao, $nome, $pokemon_fav, $descricao, $idusuario) {
    $sql = "INSERT INTO perfil (nome, pokemon_fav, descricao, idusuario) VALUES (?, ?, ?, ?, ?)";
    $comando = mysqli_prepare ($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sssi', $nome, $pokemon_fav, $descricao, $idusuario);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}



function editarPerfil($conexao, $nome_perfil, $pokemon_fav, $descricao, $id) {

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



function criarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed){
    $sql = "INSERT INTO stats (hp, attack, defense, sp_attack, sp_defense, speed) VALUES (?, ?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'iiiiii', $hp, $attack, $defense, $sp_attack, $sp_defense, $speed);
    
    $funcionou = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $funcionou;
}



function editarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed) {
    $sql = "UPDATE stats SET hp=?, attack=?, defense=?, sp_attack=?, sp_defense=?, speed=? WHERE idstats=?";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando, 'iiiiiii', $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, $id);
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou; 

}



function editarPokemon($conexao, $national, $nome, $gen) {
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

#=================================================================================================================

function criarBuild($conexao, $nome, $idpokemon) {
    $sql = "INSERT INTO build (nome, idpokemon) VALUES (?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando);
    $Feito = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $Feito;    

}

function editarBuild($conexao, $nome, $id, $idpokemon) {
    $sql = "UPDATE build SET nome=?, idpokemon=? WHERE idbuild=?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 'sii', $nome, $idpokemon, $id); // Corrigido o bind_param
    $funcionou = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $funcionou;
}


function listarBuild($conexao) {
    $sql = "SELECT * FROM build";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);

    $lista_bd = [];
    while ($bd = mysqli_fetch_assoc($resultados)) {
        $pokemon_idpokemon = $bd['idpokemon'];
        $pokemon = pesquisarPokemonId($conexao, $pokemon_idpokemon);
        $bd['nomepokemon'] = $pokemon['nome'];

        $lista_bd[] = $bd;
    }

    mysqli_stmt_close($comando);
    return $lista_bd;
}



#=================================================================================================================

function pesquisarTipos($conexao, $nome) {
    $sql = "SELECT * FROM types WHERE nome = ?";
    $comando = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($comando, 's', $nome);

    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);

    $types = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($comando);
    return $types;


}



#=================================================================================================================

function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao) {
    
}


?>