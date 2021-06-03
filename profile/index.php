<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$id = "";
	if(isset($_GET["id"])){
		$id = $_GET["id"];

		session_start();

		if(isset($_SESSION["userid"])){
			
			if($id == $_SESSION["userid"]){	//se o usuario tentar entrar no perfi dele redireciona
				header("Location: /orginfo/selfprofile");
			}

			$userid = $_SESSION["userid"];

			abreConexao();

			$dados = selectFirstSQL("SELECT * FROM usuario WHERE identificador = $id");

			if($dados == null){
				header("Location: /orginfo/search");
			}

			$nome = $dados["nome"];
			$descricaop = $dados["descricao"];
			if($descricaop == ""){
				$descricaop = "O usuário não inseriu uma descrição";
			}
			$descricaog = $dados["descricao_completa"];
			if($descricaog == ""){
				$descricaog = "O usuário não inseriu uma descrição.";
			}
			$celular = '('.substr($dados["celular"], 0, 2).') '.substr($dados["celular"], 2, 10);;
			$str = $dados["estrelas"];
			if($dados["totavaliacoes"] != 0){
				$str /= $dados["totavaliacoes"];
			}
			$stars = round($str);
			$estrelas = "";
			for($i = 1; $i <= $stars; $i++){
				$estrelas = $estrelas."🟊";
			}
			$notestrelas = "";
			for($i = $stars +1; $i <= 5; $i++){
				$notestrelas = $notestrelas."🟊";
			}

			$fotoperfil = $imgpathRedux.$dados["fotopath"];
			$fototempo = $imgpath.$dados["fotopath"];

			fechaConexao();
		}else{
			header("Location: /orginfo/profile/novo.php");
		}

	}else{
		header("Location: /orginfo/");
	}



	function printAvaliacoes($id_serv){
		$dados = selectSQL("SELECT a.identificador as id_serv, b.comentario as comentario, b.estrelas as estrelas, b.preco as preco, c.nome as nome FROM servico as a
			INNER JOIN avaliacao as b ON a.identificador = b.idservico
			INNER JOIN usuario as c ON b.idusuario = c.identificador WHERE a.identificador = $id_serv");

		if(empty($dados)){
			echo "<span class='mensagem-avaliacao'>Não há nenhuma avaliação para esse serviço</span>";
		}else{

			foreach($dados as $dado){

				$nomec = explode(" ", $dado["nome"]);
				$nome = $nomec[0];
				if(empty($nomec[1])){
					$sobrenome = " ";
				}else{
					$sobrenome = $nomec[1][0].".";
				}
				
				echo "<div class='avaliacao-usuario'>
						<span class='nome-avaliador'>".$nome." ".$sobrenome."</span>
						<span class='avaliacao-box'>🟊 ".number_format($dado["estrelas"],1)."</span>
						<span class='preco-box'><span class='preco-escuro'>";

						for($i = 1; $i <= round($dado['preco']); $i++){
							echo "$";
						}
						
						echo "</span>";

						for($i = round($dado['preco']) +1; $i <= 5; $i++){
							echo "$";
						}
						
						echo "</span>
						<span class='comentario-avaliador'>".$dado["comentario"]."</span>
					</div>";

			}

		}
	}

	function printBox($dados){
		global $imgservpath;
		global $imgservpathRedux;
		global $imgpath;
		global $imgpathRedux;
		global $id;

		$estrelas = $dados['estrelas'];
		$preco = $dados['preco'];
		if($dados['totavaliacoes'] != 0){
			$estrelas /= $dados['totavaliacoes'];
			$preco /= $dados['totavaliacoes'];
		}

		echo "<div class='row-servico'>
				<div class='box-resultado disable-hover'>
					<div class='img-box-resultado'>
						<div class='img-box-link'>
							<div class='img-box-resultado-image' style='background: url(\"".$imgservpathRedux.$dados["fotopath_serv"]."?".filemtime($imgservpath.$dados["fotopath_serv"])."\") center center / cover no-repeat'>
							</div>
						</div>
					</div>
					<div class='corpo-box-resultado'>
						<div class='texto-box-link'>
							<span class='area-box-resultado'>".mb_strtoupper($dados["nome_grupo"])." ❯ ".mb_strtoupper($dados["nome_servico"])."</span>
							<span class='titulo-box-resultado'>".$dados['titulo']."</span>
							<span class='texto-box-resultado'>".$dados['desc_serv'] ."</span>
						</div>
					</div>
					<div class='info-box-resultado'>
						<div class='info-box-link'>";
							
							if(!$dados['usuario_avaliacao']){
								echo "<button class='avaliar-box' onclick='abre_avaliacao(".$dados['id_serv'].")'>Avaliar Serviço</button>";
							}else{
								echo "<span class='ja-avaliado-box'>Você Avaliou</span>";
							}

							echo "<span class='avaliacao-box'>🟊 ".number_format($estrelas,1)."</span>
							<span class='preco-box'><span class='preco-escuro'>";

							for($i = 1; $i <= round($preco); $i++){
								echo "$";
							}
							
							echo "</span>";

							for($i = round($preco) +1; $i <= 5; $i++){
								echo "$";
							}
							
							echo "</span>
						</div>
					</div>
				</div>


				<div class='avaliacoes-box'>
					<span class='titulo-avaliacoes'>Avaliações dos usuários</span>
					<div class='avaliacoes-resultado'>";

						printAvaliacoes($dados["id_serv"]);
						
					echo "</div>
					<div class='fade-fim'></div>
				</div>";

				if(!$dados['usuario_avaliacao']){

					echo "<div class='usuario-avalia-box' id='box-".$dados['id_serv']."'>
						<span class='titulo-avaliacoes'>Avalie esse serviço</span>
						<button class='fechar-aba' onclick='fecha_avaliacao(".$dados['id_serv'].")'> 🞪 </button>
						<div class='usuario-avalia'>
							<form action='/orginfo/profile/addavaliacao.php?id_perfil=".$id."&id_serv=".$dados['id_serv']."' id='avaliacao".$dados['id_serv']."' method='POST'>
								<textarea class='comentario-avaliacao' id='avaliacao".$dados['id_serv']."' name='comentario' form='avaliacao".$dados['id_serv']."' placeholder='Faça um comentário sobre o serviço...' maxlength='300' required></textarea>

								<div class='box-nota'>
									<span class='titulo-nota'>Nota Geral</span>
									<span class='nota nota-estrela'>
										<button type='button' id='nota1' class='nota-normal' onclick='seleciona_nota(this, 1)'>🟊</button>
										<button type='button' id='nota2' class='nota-normal' onclick='seleciona_nota(this, 2)'>🟊</button>
										<button type='button' id='nota3' class='nota-normal' onclick='seleciona_nota(this, 3)'>🟊</button>
										<button type='button' id='nota4' class='nota-normal' onclick='seleciona_nota(this, 4)'>🟊</button>
										<button type='button' id='nota5' class='nota-normal' onclick='seleciona_nota(this, 5)'>🟊</button>
									</span>
									<input type='hidden' name='estrelas' value='0' required>
								</div>

								<div class='box-nota'>
									<span class='titulo-nota'>Preço</span>
									<span class='nota nota-preco'>
										<button type='button' id='nota1' class='nota-normal' onclick='seleciona_nota(this, 1)'>$</button>
										<button type='button' id='nota2' class='nota-normal' onclick='seleciona_nota(this, 2)'>$</button>
										<button type='button' id='nota3' class='nota-normal' onclick='seleciona_nota(this, 3)'>$</button>
										<button type='button' id='nota4' class='nota-normal' onclick='seleciona_nota(this, 4)'>$</button>
										<button type='button' id='nota5' class='nota-normal' onclick='seleciona_nota(this, 5)'>$</button>
									</span>
									<input type='hidden' name='preco' value='0' required>
								</div>

								<input class='botao-blue' type='submit' name='submit' value='Enviar Avaliação'>
							</form>
						</div>
					</div>";
				}

			echo "</div>";
	}

	function printBoxes(){

		global $id;
		global $userid;

		abreConexao();

		$dados = selectSQL("SELECT a.identificador as id_serv, a.titulo as titulo, a.descricao_servico as desc_serv, a.estrelas as estrelas, a.preco as preco, a.totavaliacoes as totavaliacoes, a.fotopath as fotopath_serv, b.nome as nome, b.identificador as id_pessoa, b.fotopath as fotopath_pessoa, c.nome_servico as nome_servico, c.grupo_servico as grupo_servico, d.nome_grupo as nome_grupo, e.idusuario as usuario_avaliacao FROM servico as a 
			INNER JOIN usuario as b ON a.idusuario = b.identificador 
			INNER JOIN tipo_servico as c ON a.tipo_servico = c.identificador 
			INNER JOIN grupo_servico as d ON c.grupo_servico = d.identificador 
			LEFT JOIN avaliacao as e ON e.idusuario = $userid AND e.idservico = a.identificador 
			WHERE a.idusuario = $id");

		if(empty($dados)){
			echo "<span class='mensagem-servicos'>Não há nenhum serviço disponível nesse perfil</span>";
		}else{
			foreach($dados as $dado){
				printbox($dado);
			}
		}
		fechaConexao();

	}

	function printBairros(){
		global $id;
		global $userid;

		abreConexao();

		$dados = selectSQL("SELECT * FROM bairro_usuario as a 
			INNER JOIN bairro as b ON a.idbairro = b.identificador
			WHERE idusuario = $id");

		$i = 0;

		if(empty($dados)){
			echo "Nenhum bairro foi adicionado";
		}else{
			foreach($dados as $dado){
				if($i == sizeof($dados) -1)
					echo $dado['nome'] ;
				else
					echo $dado['nome'] . " / ";
				$i++;
			}
		}
		fechaConexao();
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
		<div id="corpo-pagina">
			<div class="container">
				<header id="header">
					<div id="header-logo">
						<a href="/orginfo/">
							<img id="header-logo-image" src="/orginfo/img/logo_colored.png">
						</a>
					</div>
					<div id="header-search-box">
						<div id="input-search">
							<form id="search-form" action="/orginfo/search" method="get">
								<input id="input-search-form" type="text" name="q" placeholder="O que você precisa hoje?" autocomplete="off">
							</form>
						</div>
						<div id="icon-search">
							<img id="header-search-button" src="/orginfo/img/search.png">
						</div>
					</div>	
										
					<?=getProfileHeader()?>
				</header>
			</div>
			<div class="container">
				<div id="corpo">
					<div class="corpo-reduzido flex-row">
						
						<div class="coluna-esquerda">
							<div class="box-perfil">
								<div class="foto-perfil">
									<img src= <?=$fotoperfil?>?<?=filemtime($fototempo)?>>
								</div>
								<div class="info-perfil">
									<span class="nome-perfil"><?=$nome?></span>
									<span class="sobre-perfil"><?=$descricaop?></span>
									<span class="estrelas-perfil"><span class="estrelas-amarelas"><?=$estrelas?></span><?=$notestrelas?></span>

									<span class="divisor"></span>

									<span class="mensagem-contato">Entre em contato:</span>
									<span class="num-contato"><?=$celular?></span>
								</div>
							</div>

							<div class="box-extra">
								<span class="semi-titulo">Descrição</span>
								<span class="texto-descricao"><?=$descricaog?></span>

								<span class="semi-titulo">Bairros que trabalha</span>
								<span class="texto-descricao"><?=printBairros()?></span>
							</div>
						</div>
						<div class="coluna-direita">
							<span class="titulo-servicos">Serviços Ofertados</span>
							<div class="listagem">
								
								<?=printBoxes()?>
								
							</div>
							
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
	
	function abre_avaliacao(index){
		document.getElementById("box-" + index).style.display = "block";
		setTimeout(function(){
			document.getElementById("box-" + index).style.opacity = 1;
		}, 50);
	}
	function fecha_avaliacao(index){
		document.getElementById("box-" + index).style.opacity = 0;
		setTimeout(function(){
			document.getElementById("box-" + index).style.display = "none";
		}, 300);
	}
	function seleciona_nota(obj, num){
		var atual = obj;
		atual.classList.remove("nota-normal");
		atual.classList.add("nota-selecionada");

		for(i=num-1; i>0; i--){
			atual = atual.previousElementSibling;
			atual.classList.remove("nota-normal");
			atual.classList.add("nota-selecionada");
		}
		atual = obj;
		for(i=num; i<5; i++){
			atual = atual.nextElementSibling;
			atual.classList.remove("nota-selecionada");
			atual.classList.add("nota-normal");
		}

		obj.parentElement.nextElementSibling.value = num;
	}

</script>