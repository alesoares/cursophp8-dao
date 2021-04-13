<?php 
// CRIANDO CLASSE QUE AUXILIA NA EXECUÇÃO NO BANCO

class Sql extends PDO {

	private $conn;

	public function __construct() {

		$this -> conn = new PDO( "mysql:dbname=dbphp8;host=localhost", "root", "Soa1@1res" );
	}

	private function setParams( $statement, $parameters = array() ) {

		foreach ( $parameters as $key => $value ) {
			
			$this -> setParam( $statement, $key, $value );

		}
	}

	private function setParam( $statement, $key, $value ) {

		$statement -> bindParam( $key, $value );

	}

	public function execQuery( $rawQuery, $params = array() ) {

		$stmt = $this -> conn -> prepare( $rawQuery );

		$this -> setParams( $stmt, $params );

		$stmt -> execute();

		return $stmt;

	}

	public function select( $rawQuery, $params = array() ):array { 

		$stmt = $this -> execQuery( $rawQuery, $params );

		return $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}


}

?>