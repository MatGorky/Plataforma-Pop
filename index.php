<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	if(isset($_GET["logout"]) && $_GET["logout"] == 1){
		finalizaSessao();
	}



	function getBackgroundImage(){
		$num = mt_rand(0, 3);

		if($num == 0){
			echo "background: url('/orginfo/img/back_mecanico.png') center center / cover no-repeat;";
		}else if($num == 1){
			echo "background: url('/orginfo/img/back_designer.png') center center / cover no-repeat;";
		}else if($num == 2){
			echo "background: url('/orginfo/img/back_marceneiro.png') center center / cover no-repeat;";
		}else if($num == 3){
			echo "background: url('/orginfo/img/back_pedreiro.png') center center / cover no-repeat;";
		}
	}
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
		<div id="background-image" style="<?=getBackgroundImage()?>">
		</div>
		<div id="corpo-pagina">
			<header id="front-header">
				<?=getProfileHeader()?>
			</header>

			<div id="front-corpo">
				<div id="front-logo">
					<img id="front-logo-image" src="/orginfo/img/logo.png">
				</div>
				<div id="front-search-box">
					<div id="input-search">
						<form id="search-form" action="search" method="get">
							<input id="input-search-form" type="text" name="q" placeholder="O que você precisa hoje?" value="" autocomplete="off">
						</form>
					</div>
					<div id="icon-search">
						<img id="search-button" src="/orginfo/img/search.png">
					</div>
				</div>
			</div>

			<footer id="front-footer">
				<div id="footer-text">
					<span>
						© 2019 Plataforma Online de Profissionais - Todos os direitos reservados
					</span>
				</div>
			</footer>
		</div>
	</div>

</body>