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

}



function editarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed) {

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



function pesquisarPokemon($conexao, $idpokemon) {
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

function criarBuild($conexao, $nome) 
    $sql = "INSERT INTO tb_build (idusuario, idperfil, idstats, idPokemon) VALUES (?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($comando);
    $Feito! = mysqli_stmt_execute($comando);

    mysqli_stmt_close($comando);
    return $Feito!;    



function editarBuild($conexao, $nome, $id) {

}



function listarBuild($conexao) {
    $sql = "SELECT * FROM tb_build";
    $comando = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_execute($comando);
    $resultados = mysqli_stmt_get_result($comando);
    
    while ($venda = mysqli_fetch_assoc($)) 
        $idcliente = $venda['idusuario'];
        $cliente = pesquisarClienteid($conexao, $idcliente);
        $venda['nomeusuario'] = $cliente['nome'];
        
        $idproduto = $venda['id'];
        $produto = pesquisarPokemonid($conexao, $idproduto);
        $venda['nome'] = $produto['nome'];
        
        $lista_venda[] = $venda;
}


#=================================================================================================================

function pesquisarTipos($conexao, $idtypes) {

}



#=================================================================================================================

function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao) {
    
}

function PesquisarBuild($conexao, $nome, $id) 



?>