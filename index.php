<?php 

require_once( "config.php" );
// NESTA FORMA DE CHAMADA SOMENTE UM USUÁRIO INFORMADO TEM SEUS DADOS VINDOS DO BANCO DE DADOS
/*
$alessandro = new Usuario();

$alessandro -> loadById( 4 );

echo $alessandro;
*/

// NESTA FORMA DE CHAMADA UMA LISTA DE USUÁRIOS TEM SEUS DADOS VINDO DO BANCO DE DADOS; DETALHE O MÉTODO "getList" FOI CRIADO COM SEU MODIFICADOR DE ACESSO SENDO "STATIC"; POSSO CHAMA-LO DIRETO POR SEU OBJETO INSTANCIADO DA CLASSE "USUARIO.PHP"
/*
$lista = Usuario::getList();

echo json_encode( $lista );
*/

// NESTA FORMA DE CHAMADA UM USUÁRIO ESPECÍFICO PROGRAMÁVEL(POR INPUTS DA VIDA) TEM SEUS DADOS VINDO DO BANCO DE DADOS; CONFORME MÉTODO "search" FOI CRIADO COM SEU MODIFICADOR DE ACESSO SENDO "STATIC"; POSSO CHAMA-LO DIRETO POR SEU OBJETO INSTANCIADO DA CLASSE "USUARIO.PHP"
/*
$search = Usuario::search( "u" );// aqui vai o parâmetro exato para buscar o usuário cadastrado no banco

echo json_encode( $search );
*/

// NESTA FORMA DE CHAMADA UM USUÁRIO ESPECÍFICO PROGRAMÁVEL(POR INPUTS DA VIDA) COM SEU LOGIN E SENHA TEMOS SEUS DADOS VINDO DO BANCO DE DADOS; CONFORME MÉTODO "login" FOI CRIADO SEM SEU MODIFICADOR DE ACESSO "STATIC" O QUE O AMARRA A CLASSE EM QUESTÃO; JA NÃO POSSO CHAMA-LO DIRETO POR SEU OBJETO INSTANCIADO DA CLASSE "USUARIO.PHP"

$usuario = new Usuario();

$usuario -> login( "alessandro", "soa1@1res" );

echo $usuario;


?>