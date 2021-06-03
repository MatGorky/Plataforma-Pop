<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<head>
	<title>Plataforma Online de Profissionais</title>

	<link href="/orginfo/arquivos/basico.css" rel="stylesheet" type="text/css">

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
							<img class="imagem-central" src="/orginfo/img/profissionais.png">
							<span class="titulo-central">Seja Bem Vindo, Visitante!</span>
							<span class="mensagem-central">O acesso à pagina e contato dos profissionais é disponibilizado apenas para usuários cadastrados.</span>
							<span class="mensagem-central">Se quiser ter acesso aos melhores profissionais acesse um dos links abaixo.</span>

							<a href="/orginfo/novo_perfil/" class="link-log" style="margin-bottom: 20px;">Ainda não possuo cadastro > </a>
							<a href="/orginfo/login/" class="link-log" style="margin-top: 20px;">Já possuo cadastro > </a>
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
