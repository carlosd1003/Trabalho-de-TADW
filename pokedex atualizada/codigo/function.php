<?php
    function criarUsuario($conexao, $email, $senha, ) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (email, senha, nome_perfil, pokemon_fav) VALUES (?, ?, ? ,?)";
        $comando = mysqli_prepare($conexao, $sql);

        mysqli_stmt_bind_param($comando, 'ssss', $email, $senha_hash, $nome_perfil, $pokemon_fav);

        $funcionou = mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);

        return $funcionou;
    }



function editarUsuario($conexao, $email, $senha, $id) {

}



#=================================================================================================================

function criarPefil($conexao, $nome_perfil, $pokemon_fav, $descricao) {

}



function editarPefil($conexao, $nome_perfil, $pokemon_fav, $descricao, $id) {

}



#=================================================================================================================

function criarPokemon ($conexao, $national, $nome, $gen) {

}



function criarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed){

}



function editarStats ($conexao, $hp, $attack, $defense, $sp_attack, $sp_defense, $speed) {

}



function editarPokemon($conexao, $national, $nome, $gen) {

}



function listarPokemon($conexao) {

}



function pesquisarPokemon($conexao, $idpokemon) {

}

#=================================================================================================================

function criarBuild($conexao, $nome) {

}



function editarBuild($conexao, $nome, $id) {

}



function listarBuild($conexao) {

}



#=================================================================================================================

function pesquisarTipos($conexao, $idtypes) {

}



#=================================================================================================================

function criaSugestao_reclamacao($conexao, $reclamacao, $sugestao) {
    
}




?>