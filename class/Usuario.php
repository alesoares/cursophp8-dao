<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

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

// TRAZ SOMENTE O ÚNICO USUÁRIO CADASTRADO NO BANCO CORRESPONDENTE AO SEU ID OU QUALQUER COISA QUE O IDENTIFQUE CONFORME SOLICITAÇÃO PROGRAMÁVEL
    public function loadById( $id ) {

    	$sql = new SQL();

    	$results = $sql -> select( "SELECT * FROM tb_usuarios WHERE idusuario = :ID", array( ":ID" => $id ) );

    	if ( count( $results ) > 0 ) {
    		
    		$row = $results[0];

    		$this -> setIdusuario( $row[ 'idusuario' ] );
    		$this -> setDeslogin( $row[ 'deslogin' ] );
    		$this -> setDessenha( $row[ 'dessenha' ] );
    		$this -> setDtcadastro( new DateTime( $row[ 'dtcadastro' ] ) );
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
            
            $row = $results[0];

            $this -> setIdusuario( $row[ 'idusuario' ] );
            $this -> setDeslogin( $row[ 'deslogin' ] );
            $this -> setDessenha( $row[ 'dessenha' ] );
            $this -> setDtcadastro( new DateTime( $row[ 'dtcadastro' ] ) );
        } else{
            throw new Exception( "Login e/ou senha inválidos." );            
        }

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