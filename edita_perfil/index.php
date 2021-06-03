<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	checaSessao();

	abreConexao();

	$userid = $_SESSION["userid"];

	if (mysqli_connect_errno()) die();		//caso tenha erro finaliza

	$dados = selectFirstSQL("SELECT * FROM usuario WHERE identificador = $userid");
	extract($dados);

	$nome1 = explode(" ", $nome);
	$nome1 = $nome1[0];

	fechaConexao();

	function printBairros(){
		global $userid;

		abreConexao();

		$dados = selectSQL("SELECT * FROM bairro as a LEFT JOIN bairro_usuario as b ON b.idusuario = $userid AND a.identificador = b.idbairro ");

		$i = 0;

		foreach($dados as $dado){
			if($dado['idusuario']){
				echo "<div class='checkbox-bairro'>
						<input type='checkbox' name='bairro".$dado['identificador']."' checked>
						<span class='titulo-checkbox'>".$dado['nome']."</span>
					</div>";
			}else{
				echo "<div class='checkbox-bairro'>
						<input type='checkbox' name='bairro".$dado['identificador']."'>
						<span class='titulo-checkbox'>".$dado['nome']."</span>
					</div>";
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
							 <span class="titulo-inicial">Olá, <?=$nome1?>!</span>
							 <span class="mensagem-inicial">Para atualizar seus dados basta inserir os novos, caso não queira atualizar algum basta deixar como está.</span>
							 <br>
							 <form action="atualiza.php" method="post" id="registro" enctype="multipart/form-data">
							 	<input class="input-format" type="text" name="nome" placeholder="Nome" maxlength="80" required value="<?=$nome?>">
							 	<input class="input-format" type="email" name="email" placeholder="E-mail" maxlength="32" required value="<?=$email?>">
							 	<input class="input-format" type="tel" name="celular" placeholder="Celular" min="0" max="99999999999" required value="<?=$celular?>">
							 	<input class="input-format" type="password" name="senha" placeholder="Nova senha" maxlength="16" value="">
							 	<input class="input-format input-arquivo" type="file" name="imagem" accept="image/*" id="imagem" value="">
							 	<div class="fake-input-arquivo">
							 		<span id="fake1">Selecionar uma nova imagem para perfil ⏵</span>
							 	</div>

							 	<br>

							 	<label class="textarea-label" for="descricaop">Descricao Breve</label>
								<textarea class="textarea-format-p" name="descricaop" id="descricaop" form="registro" placeholder="Escreva aqui uma breve descrição sobre você..." maxlength="58"><?=$descricao?></textarea>

								<label class="textarea-label" for="descricaog">Descricao Completa</label>
								<textarea class="textarea-format-m" name="descricaog" id="descricaog" form="registro" placeholder="Escreva aqui uma descrição completa sobre você, suas especialidades, formação e o que mais quiser contar..." maxlength="300"><?=$descricao_completa?></textarea>

								<label class="textarea-label">Bairros que Trabalha</label>
								<div class="grupo-checkbox-bairro">

									<?=printBairros()?>

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