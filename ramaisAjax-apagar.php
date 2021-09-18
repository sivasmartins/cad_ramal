<?php 
	require_once './db/banco.php';
	require_once 'functions/functions.php';

	mysqli_select_db($conexao, $database);

	$faz=false;
	$codigo = $_REQUEST['vcodigo'];

	$qryRamal = "DELETE FROM ramal where id_ramal=".$codigo;

	$DelRamal = mysqli_query($conexao, $qryRamal);

	$erroMy = mysqli_error($DelRamal);
	$cMsg   = htmlentities($erroMy['message']);

	if($cMsg ==""){
		$faz = true;
	}

	if($faz){
		echo "var info=new Array(); info[0]=true;";
	}else{
		echo "var info=new Array(); info[0]=false; info[1]='$cMsg';";
	}
?>

