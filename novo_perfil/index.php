<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$nome = "";
	$cpf = "";
	$celular = "";
	$email = "";
	$fotopath = "";

	if(isset($_POST["submit"])){
		extract($_POST);

		//fazer verificacoes

		abreConexao();

		if (mysqli_connect_errno()) die();		//caso tenha erro finaliza

	    $hash = password_hash($senha, PASSWORD_DEFAULT);

	    $retorno = insertSQL("INSERT INTO usuario (nome, cpf, email, celular, senha) VALUES ('$nome', $cpf, '$email', $celular, '$hash')");

	    $dados = selectFirstSQL("SELECT identificador FROM usuario WHERE cpf = $cpf");
		$userid = $dados["identificador"];

	    if(!$retorno && $dados){
	    	$errocpf = "erro";
	    }else if(!$retorno){
	    	$errogeral = 1;
	    }else{

			if($dados){
				iniciaSessao($userid);

			    header("Location: /orginfo/novo_perfil");
			} 

		    if($_FILES["imagem"]["name"] != ""){

				$img = basename($_FILES["imagem"]["name"]); 	//nome original da imagem, serve para adquirir a extensão

				$tipo = strtolower(pathinfo($img,PATHINFO_EXTENSION)); 		//tipo de arquivo (extensão)
		    	$tiposPermitidos = array('jpg','png','jpeg');//apenas imagens

		    	if(in_array($tipo, $tiposPermitidos)){
		    		$foto = "perfil_" . $userid . "." . $tipo; 	
		    		$caminho = $imgpath . $foto;


		     		if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)){  //o "tmp_name" aqui, é porque o 
		            	updateSQL("UPDATE usuario SET fotopath = '$foto' WHERE identificador = $userid");	  //php move ela pra um lugar temporário"
		            	
		            	cropimg($caminho);
		        	}else{
		        		die();
		        	}
		    	}else{
		        	echo "nao permitido";
		        	die();
		    	}

		    }

		    header("Location: /orginfo/selfprofile");

		}

		fechaConexao();
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
							 <span class="titulo-inicial">Seja muito Bem-Vindo!</span>
							 <span class="mensagem-inicial">Para realizar seu cadastro precisaremos apenas de alguns dados.</span>
							 <br>
							 <form action="" method="post" id="registro" enctype="multipart/form-data">
							 	<input class="input-format" type="text" name="nome" placeholder="Nome" maxlength="80" required value="<?=$nome?>">
							 	<input class="input-format <?=$errocpf?> " type="number" name="cpf" placeholder="CPF" min="11111111111" max="99999999999" required value="<?=$cpf?>"> 
							 	<input class="input-format" type="email" name="email" placeholder="E-mail" maxlength="32" required value="<?=$email?>">
							 	<input class="input-format" type="tel" name="celular" placeholder="Celular" min="0" max="99999999999" required value="<?=$celular?>">
							 	<input class="input-format" type="password" name="senha" placeholder="Senha" maxlength="16" required>
							 	<input class="input-format input-arquivo" type="file" name="imagem" accept="image/*" required value="<?=$fotopath?>">
							 	<div class="fake-input-arquivo">
							 		<span id="fake1">Selecione uma imagem para perfil ⏵</span>
							 	</div>

							 	<input class="botao-input" type="submit" name="submit" value="Cadastrar">
							 </form>

							 <a href="/orginfo/login/" class="link-log">Já possuo cadastro > </a>
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