<?php
require_once 'defaultdb.php';

$hostname = "localhost";
$database = "ramais";
$username = "ramais";
$password = "ramais";


$conexao = mysqli_connect($hostname, $username, $password, $database);
if (!$conexao) {
  die("Connection failed: " . mysqli_connect_error());
}

/*
if ($defaultDB == 'PRODUCAO') {
	$conexao = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
	// print_r("Banco PRODUÇÃO");
} else {
	$conexao = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error(),E_USER_ERROR);
	// print_r("Banco TESTE");
}
*/

?>