<?php 

require_once( "config.php" );

$alessandro = new Usuario();

$alessandro -> loadById( 4 );

echo $alessandro;






?>