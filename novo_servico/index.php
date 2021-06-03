<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$titulo = "";
	$descricao = "";
	$tipo = "";
	$fotopath = "";

	checaSessao();

	if(isset($_POST["submit"])){
		extract($_POST);

		//fazer verificacoes

		abreConexao();

		$userid = $_SESSION["userid"];

		if (mysqli_connect_errno()) die();		//caso tenha erro finaliza


		//checar limite de 10 servicos
		$dados = selectFirstSQL("SELECT COUNT(identificador) as c FROM servico WHERE idusuario = $userid");

		if($dados["c"] < 10){

		    $retorno = insertSQL("INSERT INTO servico (idusuario, titulo, descricao_servico, tipo_servico) VALUES ($userid, '$titulo','$descricao', $tipo)");

		    $id_servico = getLastId();

			if(!$retorno){
		    	$errogeral = 1;
		    }else{

			    if($_FILES["imagem"]["name"] != ""){

					
					$img = basename($_FILES["imagem"]["name"]); 	//nome original da imagem, serve para adquirir a extensão
					$tipo = strtolower(pathinfo($img, PATHINFO_EXTENSION)); 		//tipo de arquivo (extensão)
			    	$tiposPermitidos = array('jpg','png','jpeg');					//apenas imagens

			    	if(in_array($tipo, $tiposPermitidos)){

			    		$foto = "servico_" . $id_servico . "." . $tipo; 	
			    		$caminho = $imgservpath.$foto;

			     		if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)){		
			            	updateSQL("UPDATE servico SET fotopath = '$foto' WHERE identificador = $id_servico");	  
			            	cropimgServ($caminho);
			        	}else{
			            	//lidarei com possíveis erros no futuro, se necessário
			        	}
			    	}else{
			        //
			    	}
			    }

			}

		}

		fechaConexao();
		
		header("Location: /orginfo/selfprofile");
	}




	function printTipos(){
		$dados = selectSQL("SELECT * FROM grupo_servico");

		if(!empty($dados)){

			foreach($dados as $dado){
	
				echo "<optgroup label='".$dado["nome_grupo"]."'>";
					
					$dados2 = selectSQL("SELECT * FROM tipo_servico WHERE grupo_servico = ".$dado['identificador']);

					foreach($dados2 as $dado2){
						echo "<option value='".$dado2["identificador"]."'>".$dado2["nome_servico"]."</option>";
					}

				echo "</optgroup>";
			}
		}

	}


?>

<!DOCTYPE html>
<head>
	<title>Plataforma Online de Profissionais</title>

	<link href="/orginfo/arquivos/basico.css" rel="stylesheet" type="text/css">
	<link href="/orginfo/arquivos/selfprofile.css" rel="stylesheet" type="text/css">
	<script src="/orginfo/arquivos/jquery-3.2.1.min.js"></script>

	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/jpg" href="/orginfo/img/favicon.png" />
</head>
<body>
	
	<div id="pagina">
		<div id="corpo-pagina">
			<div class="container">
				<header id="header">
					<div id="header-logo">
						<a href="/orginfo/">
							<img id="header-logo-image" src="/orginfo/img/logo_colored.png">
						</a>
					</div>
				</header>
			</div>
			<div class="container">
				<div id="corpo">
					<div class="corpo-reduzido flex-row">
						
						<div class="box-branca-pequena centralizada caixa-cadastro">
							 <span class="titulo-inicial">Cadastro de novo Serviço</span>
							 <span class="mensagem-inicial">Para cadastrar o serviço insira as seguintes informações.</span>
							 <br>
							 <form action="" id="registro" method="POST" enctype="multipart/form-data">
							 	<input class="input-format" type="text" name="titulo" placeholder="Titulo do serviço" maxlength="26" required>
							 	<input class="input-format" type="text" name="descricao" placeholder="Descricao do serviço" maxlength="95" required>
							 	<select class="input-format select-input" name="tipo" required>
								  	<option value="" selected disabled>Selecione a Área do Serviço ⏷</option>
								  	
								  	<?=printTipos()?>

								</select> 
							 	<input class="input-format input-arquivo" type="file" name="imagem" accept="image/*" required>
							 	<div class="fake-input-arquivo">
							 		<span id="fake1">Selecione uma imagem para o banner do serviço ⏵</span>
							 	</div>

							 	<input class="botao-input" type="submit" name="submit" value="Cadastrar">
							 </form>
						</div>

					</div>
				</div>
			</div>
			<div class="container">
				<footer id="footer">
					<div id="footer-text">
						<span>
							© 2019 Plataforma Online de Profissionais - Todos os direitos reservados
						</span>
					</div>
				</footer>
			</div>
		</div>
	</div>

</body>

<script type="text/javascript">
	
	$('.fake-input-arquivo').on('click', function() {
	  	$('.input-arquivo').trigger('click');
	});
	$('.input-arquivo').on('change', function() {
	  	var fileName = $(this)[0].files[0].name;
	  	$('#fake1').innerHTML = fileName;
		$('#fake1')[0].innerHTML = fileName;
	});

</script>