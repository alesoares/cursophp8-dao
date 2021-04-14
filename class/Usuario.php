<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

// DESSA FORMA OMDE JÁ HAVIAMOS FEITO NÃO DARÁ ERRO PASSANDO COMO VÁZIO OS PARÂMETROS
// TUDO PARA MODIFICAR NO INDEX.PHP A FORMA DE CHAMAR DIMINUINDO AS LINHAS AGORA
    public function __construct( $Login = "", $Password = "" ) {

        $this -> setDeslogin( $Login );
        $this -> setDessenha( $Password );
    }

    /**
     * @return mixed
     */
    public function getIdusuario(){
        return $this->idusuario;
    }

    /**
     * @param mixed $idusuario
     *
     * @return self
     */
    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeslogin() {
        return $this->deslogin;
    }

    /**
     * @param mixed $deslogin
     *
     * @return self
     */
    public function setDeslogin($deslogin) {
        $this->deslogin = $deslogin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDessenha() {
        return $this->dessenha;
    }

    /**
     * @param mixed $dessenha
     *
     * @return self
     */
    public function setDessenha($dessenha) {
        $this->dessenha = $dessenha;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtcadastro() {
        return $this->dtcadastro;
    }

    /**
     * @param mixed $dtcadatro
     *
     * @return self
     */
    public function setDtcadastro($dtcadastro) {
        $this->dtcadastro = $dtcadastro;
        return $this;
    }
    
// TRAZ OS DADOS GRAVADOS NO BANCO PELOS MODIFICADORES DE ACESSO SETTERS
    public function setData( $data ) {

        $this -> setIdusuario( $data[ 'idusuario' ] );
        $this -> setDeslogin( $data[ 'deslogin' ] );
        $this -> setDessenha( $data[ 'dessenha' ] );
        $this -> setDtcadastro( new DateTime( $data[ 'dtcadastro' ] ) );
    }

// TRAZ SOMENTE O ÚNICO USUÁRIO CADASTRADO NO BANCO CORRESPONDENTE AO SEU ID OU QUALQUER COISA QUE O IDENTIFQUE CONFORME SOLICITAÇÃO PROGRAMÁVEL
    public function loadById( $id ) {

    	$sql = new SQL();

    	$results = $sql -> select( "SELECT * FROM tb_usuarios WHERE idusuario = :ID", array( ":ID" => $id ) );

    	if ( count( $results ) > 0 ) {    		
    		$this -> setData( $results[0] );
    	}
    }

// TRAZ UMA LISTA CONTENDO TODOS OS USUÁRIOS CADATRADOS NO BANCO
    public static function getList() {

        $sql = new SQL();

        return $sql -> select( "SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

// TRAZ UM USUÁRIO ESPECÍFICO CONFORME PARÂMETRO PROGRÁMAVEL
    public static function search( $Login ) {

        $sql = new Sql();

        return $sql -> select( "SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
                ":SEARCH" => "%" . $Login . "%"
        ));
    }

// TRAZ DADOS DE UM USUÁRIO LOGADO NO SISTEMA 
    public function login( $Login, $Password ) {
        
        $sql = new SQL();

        $results = $sql -> select( "SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array( ":LOGIN" => $Login,
            "PASSWORD" => $Password
        ) );

        if ( count( $results ) > 0 ) {
            
            $this -> setData( $results[0] );

        } else{
            throw new Exception( "Login e/ou senha inválidos." );            
        }
    }

// FAZ A INSERÇÃO DO USUÁRIO NO BANCO DE DADOS COM UMA PROCEDURE
    public function insert() {

        $sql = new SQL();

        $results = $sql -> select( "CALL sp_usuarios_insert( :LOGIN, :PASSWORD )", array( ":LOGIN" => $this -> getDesLogin(),
            "PASSWORD" => $this -> getDessenha()
        ) );
         if ( count( $results ) > 0 ) {            
            $this -> setData( $results[0] );
        } 
    }

// FAZALTERAÇÃO NOS DADOS NO BANCO DE DADOS 
    public function update( $login, $password ) {

        $this -> setDeslogin( $login );
        $this -> setDessenha( $password );

        $sql = new SQL();

        $sql -> execQuery( "UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
                    ':LOGIN' => $this -> getDeslogin(),
                    ':PASSWORD' => $this -> getDessenha(),
                    ':ID' => $this -> getIdusuario()
        ));
    }

    public function __toString() {
    	return json_encode( array(
    		"idusuario"  => $this -> getIdusuario(),
    		"deslogin"   => $this -> getDeslogin(),
    		"dessenha"   => $this -> getDessenha(),
    		"dtcadastro" => $this -> getDtcadastro() -> format( "d/m/Y  H:i:s")
    	));
    }

}

?>