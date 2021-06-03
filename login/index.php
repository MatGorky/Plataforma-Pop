<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$errocpf = "";
	$errosenha ="";
	$cpf = "";
	if(isset($_POST["cpf"]) && isset($_POST["senha"])){
		$cpf = $_POST["cpf"];
		$senha = $_POST["senha"];
		//$thishash = password_hash($senha, PASSWORD_DEFAULT);

		abreConexao();

		if (mysqli_connect_errno()) die();		//caso tenha erro finaliza

		$dados = selectFirstSQL("SELECT identificador, senha FROM usuario WHERE cpf = $cpf");
		$hash = $dados["senha"];
		$id = $dados["identificador"];

		if (password_verify($senha, $hash)) {
			iniciaSessao($id);

		    header("Location: /orginfo/selfprofile");
		} else {
		   	if($dados == null){
		   		$errocpf = "erro";
		   		$errosenha = "erro";

		   		$cpf = "";
		   	}else{
		   		$errosenha = "erro";
		   	}
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
							 <span class="mensagem-inicial">Para realizar o login preencha os campos abaixo.</span>
							 <br>
							 <form action="" method="post" id="registro">
							 	<input class="input-format <?=$errocpf?>" type="number" name="cpf" placeholder="CPF" min="11111111111" max="99999999999" required value="<?=$cpf?>">
							 	<input class="input-format <?=$errosenha?>" type="password" name="senha" placeholder="Senha" maxlength="16" required>

							 	<input class="botao-input" type="submit" value="Entrar">
							 </form>
							 
							 <a href="/orginfo/novo_perfil/" class="link-log">Ainda não possuo cadastro > </a>
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