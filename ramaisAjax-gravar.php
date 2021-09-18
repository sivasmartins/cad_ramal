<?php 
  require_once './db/banco.php';
  require_once 'functions/functions.php';

$faz=false;
$ramal = $_REQUEST['vramal'];
$nome  = $_REQUEST['vnome'];
$setor = $_REQUEST['vsetor'];

$qryRamal = "
	INSERT INTO ramal (
		  num_ramal
		, nome_ramal
		, setor_ramal

	) VALUES (
	      '$ramal'
		, '$nome'
		, '$setor'
	)
";

$InsRamal = mysqli_query($conexao, $qryRamal);

$erroMy = mysqli_error($InsRamal);
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

