<?php
	require_once './db/banco.php';
	require_once 'functions/functions.php';

	mysqli_select_db($conexao, $database);

	$sql = " 
			SELECT id_ramal as codigo, num_ramal as ramal, nome_ramal as nome, setor_ramal as setor
			FROM ramal
			ORDER BY num_ramal;
		  ";

	mysqli_select_db($conexao, $database);
	$listaRamais = mysqliResultArray($conexao, $sql);
	$rows = mysqliResultRows($conexao, $sql);  
  
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ramais</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
	<style type="text/css">
		input, textarea{text-transform: uppercase;}
		.bootstrap-dialog-footer-buttons{text-align: right;}
		.bootstrap-dialog-footer-buttons > button {margin-right: 10px;}
		[disabled]{cursor: no-drop;}
		canvas {-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;}
	</style>      
	<script>
		$(document).ready(function(){
			$('#btnAddRamal').hide();
			$('#btnModalWarning').hide();
			$('#btnDelRamal').hide();
	  
			$("#txBusca").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#tblMain tr").filter(function() {
		  			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});

			$('#btnCadastro').click(function(event) {
				$('#modalCadTitle').html('');
				$('#modalCadTitle').html('Cadastro de Ramal');
				$("#btnAddRamal").trigger('click');
			});

			$("#modalCad").on('shown.bs.modal', function(){
				$(this).find('#ramal').focus();
			});			

			$("#btnRamalSave").click(function(){
		
				if($('#ramal').val()==''){
					modalWarning('Atenção', 'O <b>Número do Ramal</b> deve ser informado!');
				} else if($('#nome').val()==''){
					modalWarning('Atenção', 'O <b>Usuário(s) do Ramal</b> deve ser informado!');
				} else if($('#setor').val()==''){
					modalWarning('Atenção', 'O <b>Setor do Ramal</b> deve ser informado!');
				} else {
					$('#divLoading').show();
					var ramal = $('#ramal').val();
					var nome  = $('#nome').val().toUpperCase();
					var setor = $('#setor').val().toUpperCase();
	
						//console.log('ramaisAjax-gravar.php?vramal='+ramal+'&vnome='+nome+'&vsetor='+setor);
	
					$.ajax({
						type: 'POST',
						url:  'ramaisAjax-gravar.php',
						data: 'vramal='+ramal+'&vnome='+nome+'&vsetor='+setor,
						success:function(msg){
							eval(msg);
					  		if(!info[0]){
								$("#divLoading").hide();
								modalWarning('Atenção', info[1]);
					  		} else {
								window.location.reload();
							}
						}
					});
				}
			});

			function modalWarning(title, message){
				$('#modalWarningTitle').html('');
				$('.modal-body-warn').html('');
				$('#modalWarningTitle').html(title);
				$('.modal-body-warn').html(message);
				$('.modal-backdrop:last').css('z-index', 1049);
				$("#btnModalWarning").trigger('click');
			}

			$('#btnRamalClose').click(function(event) {
				window.location.reload();
			});

		});

		function removeRow(codigo) {
			$('#modalDelTitleH').html('');
			$('#modalDelTitleH').html('Exclusão');
			$('#modalDelTitleB').html('');
			$('#modalDelTitleB').html('Deseja excluir o item?');			
			$("#btnDelRamal").trigger('click');
			

			$("#btnDelNao").on("click", function(){
				window.location.reload();
			});

			$("#btnDelSim").on("click", function(){
				removeRowAjax(codigo);
			});
		}

		function removeRowAjax(codigo) {
			//console.log('ramaisAjax-apagar.php?vcodigo='+codigo);
			$("#divLoading").show();
			$.ajax({
		    	type: 'POST',
		    	url:  'ramaisAjax-apagar.php',
		    	data: 'vcodigo='+codigo,
		    	success:function(msg){
		    		eval(msg);
		      		if(!info[0]){
		        		$("#divLoading").hide();
		        		modalWarning('Atenção', info[1]);
		    		}else{
		        		window.location.reload();
		      		}
		    	}
			});
		}

	</script>
</head>


<!-- Modal Confirm -->
<button type="button" id="btnDelRamal" name="btnDelRamal" class="btn btn-primary btn-hide" data-toggle="modal" data-target="#modalDel"></button>    
<div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="modalDelTitle" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalDelTitleH" name="modalDelTitleH"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  		</div>
			<div class="modal-body">
				<h6 class="modal-title" id="modalDelTitleB" name="modalDelTitleB"></h6>
			</div>          
			<div class="modal-footer">
				<button type="button" id="btnDelNao" class="btn btn-outline-secondary" data-dismiss="modal">Não</button>
				<button type="button" id="btnDelSim" name="btnDelSim" class="btn btn-outline-info">Sim</button>
			</div>
		</div>
	</div>
</div> 

<!-- Modal ADD-->
<button type="button" id="btnAddRamal" name="btnAddRamal" class="btn btn-primary btn-hide" data-toggle="modal" data-target="#modalCad"></button>
<div class="modal fade" id="modalCad" tabindex="-1" role="dialog" aria-labelledby="modalCadTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="modalCadTitle" name="modalCadTitle"></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
			  			<label for="ramal">Ramal:</label>
						<div class="input-group">
							<input type="text" id="ramal" class="form-control form-control-sm text-left float4" value="" name="ramal" autocomplete="off">
						</div>
					</div>
					<div class="col-sm-12">
			  			<label for="nome">Nome:</label>
			  			<div class="input-group">
							<input type="text" id="nome" class="form-control form-control-sm text-left text-uppercase" value="" name="nome" autocomplete="off">
			  			</div>
					</div>
					<div class="col-sm-12">
						<label for="setor">Setor:</label>
						<div class="input-group">
							<input type="text" id="setor" class="form-control form-control-sm text-left text-uppercase" value="" name="setor" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
	  		<div class="modal-footer">
				<button type="button" id="btnRamalClose" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
				<button type="button" id="btnRamalSave" name="btnRamalSave" class="btn btn-outline-success">Salvar</button>
	  		</div>
		</div>
	</div>
</div>

<!-- modal warning -->
<button type="button" id="btnModalWarning" name="btnModalWarning" class="btn btn-primary btn-hide" data-toggle="modal" data-target="#modalWarning"></button>
<div class="modal fade" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="modalWarningTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #ffffd2;">
				<h6 class="modal-title" id="modalWarningTitle" name="modalWarningTitle"></h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body modal-body-warn" style="background-color: #ffff7e;"></div>
			<div class="modal-footer" style="background-color: #ffffd2;">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- modal loading -->
<div id="divLoading" style="display: none;">
	<div style="position: fixed;left: 45%;top: 45%;z-index: 2; color: yellow;">
		<div style="text-align: center;font-size: 25px;">
			<b>PROCESSANDO</b>
		</div>
		<div style="text-align: center;">
	  		<i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
		</div>
	</div>
	<div style="position:fixed; top:0; left:0; z-index:1; width:100%; height:100%; overflow:auto; background-color:#000; opacity: 0.6; filter:alpha(opacity=99); -moz-opacity:0.9; z-index: 1;"></div>
</div>

<body>
	<div class="container-fluid pt-3 pb-5">
		<div class="card div-panel border-0 shadow rounded-3">
			<div class="card-header">
				<div class="row"> 
		  			<div class="col-sm-4 text-center"></div>
		  			<div class="col-sm-4 text-center"><h3>Ramais - Lista</h3></div>
					<div class="col-sm-4">&nbsp;</div>
				</div>
	  		</div>
			<div class="card-body p-2">
				<form id="formBusca" action="" method="get">
			  		<div class="row">
						<div class="col-sm-10">
				  			<label for="txBusca" class="control-label">&nbsp;</label>
							<div class="input-group">
								<input type="text" class="form-control form-control-sm" name="txBusca" id="txBusca" placeholder="BUSCA POR CODIGO OU DESCRIÇÃO" autocomplete="off" value="">
							</div>
						</div>
						<div class="col-sm-2">
							<label for="btnRamalCad">&nbsp;</label>
							<button type="button" id="btnCadastro" class="form-control form-control-sm btn-sm btn-outline-success">Cadastrar</button>
						</div> 
					</div>
				</form>
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<?php if($rows > 0){ ?>
				  			<table class="table table-sm table-bordered table-striped table-hover text-nowrap">
								<thead>
					  				<tr>
										<th width="10%" class="text-center">Ramal</th>
										<th width="47%" class="text-center">Nome</th>
										<th width="40%" class="text-center">Setor</th>
										<th width="3%" class="text-center">&nbsp;</th>
									</tr>
								</thead>
								<tbody id="tblMain">
									<?php
									  foreach ($listaRamais as $k1 => $v1) {
										echo '<tr>';
										echo '<td class="text-center">'.$v1['ramal'].'</td>';
										echo '<td class="text-center">'.$v1['nome'].'</td>';
										echo '<td class="text-center">'.$v1['setor'].'</td>';
										echo "<td class=\"text-center\"><button class=\"btn btn-sm btn-dark text-center font-12 p-0 ml-1\" onclick=\"removeRow('".$v1['codigo']."');\" title=\"Clique para Excluir\"><i class=\"fa fa-trash m-1\"></button></i></td>";
										echo '</tr>';
									  }
									?>
								</tbody>
				  			</table>
				  			<?php } else { echo '<div class="alert alert-danger text-center" role="alert">Nenhum Registro Encontrado</div>';
				  			}
                  			?>   
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>