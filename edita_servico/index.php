<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$titulo = "";
	$descricao = "";
	

	checaSessao();

	abreConexao();
	if (mysqli_connect_errno()) die();

	$iduser = $_SESSION['userid'];
	$id_serv = $_GET["id_serv"];
	//checa para ver se o usuário realmente é dono do serviço
	$dados = selectFirstSQL("SELECT b.titulo, b.descricao_servico FROM usuario as a INNER JOIN servico as b ON a.identificador = b.idusuario AND a.identificador = $iduser AND b.identificador = $id_serv");
	if(empty($dados))
	{
		header("Location: /orginfo/selfprofile/");
		exit();
	}
	$titulo = $dados["titulo"];
	$descricao = $dados["descricao_servico"];

	fechaConexao();	
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
							 <span class="titulo-inicial">Atualizar Dados do Serviço</span>
							 <span class="mensagem-inicial">Para atualizar os dados do serviço basta inserir os novos, caso não queira atualizar algum basta deixar como está.</span>
							 <br>
							 <form action="atualiza.php/?id_serv=<?=$id_serv?>" id="registro" method="POST" enctype="multipart/form-data">
							 	<input class="input-format" type="text" name="titulo" placeholder="Titulo do serviço" maxlength="26" required value ="<?=$titulo?>">
							 	<input class="input-format" type="text" name="descricao" placeholder="Descricao do serviço" maxlength="95" required value ="<?=$descricao?>">
							 	<input class="input-format input-arquivo" type="file" name="imagem" accept="image/*">
							 	<div class="fake-input-arquivo">
							 		<span id="fake1">Selecione uma imagem para o banner do serviço ⏵</span>
							 	</div>

							 	<input class="botao-input" type="submit" name="submit" value="Atualizar Informações">
							 </form>
						</div>

					</div>
				</div>
			</div>
			<div class="container">
				<footer id="footer">
					<div id="footer-text">
						<span>
							© 2019 Sistema Online de Profissionais - Todos os direitos reservados
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