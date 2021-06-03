<?php 

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";

	header('Content-Type: text/html; charset=UTF-8');

	$pesquisa = "";
	$bairro = null;
	if(isset($_GET["q"])){
		$pesquisa = $_GET["q"];
	}else{
		header("Location: /orginfo/");
	}

	if(isset($_GET["bairro"])){
		$bairro = $_GET["bairro"];
	}

	function printBox($dados){
		$nomec = explode(" ", $dados["nome"]);
		$nome = $nomec[0]; 
		if(empty($nomec[1])){
			$sobrenome = " ";
		}else{
			$sobrenome = $nomec[1][0].".";
		}

		$estrelas = $dados['estrelas'];
		$preco = $dados['preco'];
		if($dados['totavaliacoes'] != 0){
			$estrelas /= $dados['totavaliacoes'];
			$preco /= $dados['totavaliacoes'];
		}

		global $imgservpath;
		global $imgservpathRedux;
		global $imgpath;
		global $imgpathRedux;

		echo "<div class='box-resultado'>
			<div class='img-box-resultado'>
				<a class='img-box-link' href='/orginfo/profile?id=".$dados["id_pessoa"]."'>
					<div class='img-box-resultado-image' style='background: url(\"".$imgservpathRedux.$dados["fotopath_serv"]."?".filemtime($imgservpath.$dados["fotopath_serv"])."\") center center / cover no-repeat'>
					</div>
				</a>
			</div>
			<div class='corpo-box-resultado'>
				<a class='texto-box-link' href='/orginfo/profile?id=".$dados["id_pessoa"]."'>
					<span class='area-box-resultado'>".mb_strtoupper($dados["nome_grupo"])." ❯ ".mb_strtoupper($dados["nome_servico"])."</span>
					<span class='titulo-box-resultado'>".$dados['titulo']."</span>
					<span class='texto-box-resultado'>".$dados['desc_serv'] ."</span>
				</a>
			</div>
			<div class='info-box-resultado'>
				<a class='info-box-link' href='/orginfo/profile?id=".$dados["id_pessoa"]."'>
					<img class='perfil-box' src=".$imgpathRedux.$dados["fotopath_pessoa"]."?".filemtime($imgpath.$dados["fotopath_pessoa"]).">
					<span class='nome-box'>".$nome." ".$sobrenome."</span>
					<span class='avaliacao-box'>🟊 ".number_format($estrelas, 1)."</span>
					<span class='preco-box'><span class='preco-escuro'>";

					for($i = 1; $i <= round($estrelas); $i++){
						echo "$";
					}
					
					echo "</span>";

					for($i = round($estrelas) +1; $i <= 5; $i++){
						echo "$";
					}
					
					echo "</span>
				</a>
			</div>
		</div>";
	}

	function printBoxes(){

		abreConexao();

		$dados = selectSQL("SELECT a.identificador as id_serv, a.titulo as titulo, a.descricao_servico as desc_serv, a.estrelas as estrelas, a.preco as preco, a.totavaliacoes as totavaliacoes, a.fotopath as fotopath_serv, b.nome as nome, b.identificador as id_pessoa, b.fotopath as fotopath_pessoa, c.nome_servico as nome_servico, c.grupo_servico as grupo_servico, d.nome_grupo as nome_grupo FROM servico as a 
			INNER JOIN usuario as b ON a.idusuario = b.identificador 
			INNER JOIN tipo_servico as c ON a.tipo_servico = c.identificador
			INNER JOIN grupo_servico as d ON c.grupo_servico = d.identificador 
			ORDER BY (a.estrelas / a.totavaliacoes) DESC");

		foreach($dados as $dado){
			printbox($dado);
		}

		fechaConexao();

	}

	function printPesquisa(){
    	function tirarAcentos($string){
		    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
		}

    	global $pesquisa, $conexao, $bairro;

    	abreConexao();

    	$ranking = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());

    	if($bairro == null){
        	$resp = mysqli_query($conexao, "SELECT a.identificador as id_serv, a.titulo as titulo, a.descricao_servico as desc_serv, a.estrelas as estrelas, a.preco as preco, a.totavaliacoes as totavaliacoes, a.fotopath as fotopath_serv, b.nome as nome, b.identificador as id_pessoa, b.fotopath as fotopath_pessoa, c.nome_servico as nome_servico, c.grupo_servico as grupo_servico, d.nome_grupo as nome_grupo FROM servico as a 
			INNER JOIN usuario as b ON a.idusuario = b.identificador 
			INNER JOIN tipo_servico as c ON a.tipo_servico = c.identificador
			INNER JOIN grupo_servico as d ON c.grupo_servico = d.identificador 
			ORDER BY (a.estrelas / a.totavaliacoes) DESC");
    	}else{
    		$resp = mysqli_query($conexao, "SELECT a.identificador as id_serv, a.titulo as titulo, a.descricao_servico as desc_serv, a.estrelas as estrelas, a.preco as preco, a.totavaliacoes as totavaliacoes, a.fotopath as fotopath_serv, b.nome as nome, b.identificador as id_pessoa, b.fotopath as fotopath_pessoa, c.nome_servico as nome_servico, c.grupo_servico as grupo_servico, d.nome_grupo as nome_grupo FROM servico as a 
			INNER JOIN usuario as b ON a.idusuario = b.identificador 
			INNER JOIN tipo_servico as c ON a.tipo_servico = c.identificador
			INNER JOIN grupo_servico as d ON c.grupo_servico = d.identificador
			INNER JOIN bairro_usuario as e ON b.identificador = e.idusuario AND e.idbairro = $bairro 
			ORDER BY (a.estrelas / a.totavaliacoes) DESC");
    	}

        $linha = mysqli_fetch_assoc($resp);

        while($linha != null){
        	$texto = $linha["titulo"]." ".$linha["desc_serv"]." ".$linha["nome_servico"]." ".$linha["nome_grupo"]." ".$linha["nome"];

        	$p1 =  preg_replace('/[\'.,;]+/', "", strtoupper(tirarAcentos($texto)));
			$p2 = preg_replace('/[\'.,;]+/', "", strtoupper(tirarAcentos($pesquisa)));

			$palavras =  preg_split('/[\ \n\,"\'.:()\[\]{};-]+/', $p1);
			$palavra = preg_split('/[\ \n\,"\'.:()\[\]{};-]+/', $p2);

			$maior_percent = 0;
			$percent_tot = 0;
			$i = 0;

			foreach($palavra as $pesq){
				$i++;
				$maior_percent = 0;

				foreach($palavras as $str){
					similar_text($str, $pesq, $percent);

					if($percent > $maior_percent){
						$maior_percent = $percent;
					}
				}

				$percent_tot += $maior_percent;			
			}

			$percent_fim = $percent_tot / $i;

			if($percent_fim >= 75.0){
				if($maior_percent <= 80.0){
					array_push($ranking[5], $linha); 
				}else if($maior_percent <= 85.0){
					array_push($ranking[4], $linha); 
				}else if($maior_percent <= 90.0){
					array_push($ranking[3], $linha); 
				}else if($maior_percent <= 95.0){
					array_push($ranking[2], $linha); 
				}else{
					array_push($ranking[1], $linha); 
				}
			}

        	$linha = mysqli_fetch_assoc($resp);
    	}
    	
    	if($ranking[1] != null || $ranking[2] != null || $ranking[3] != null || $ranking[4] != null || $ranking[5] != null){

	    	for($i = 1; $i <= 5; $i++){
	    		foreach($ranking[$i] as $linha){

	    			printBox($linha);

				}
	    	}

	    }else{
	    	echo "<span class='mensagem-zerado'>Não há nenhum serviço relacionado à pesquisa</span>";
		}

		fechaConexao();
	}

	function printFiltroBairros(){
		global $pesquisa;
		global $bairro;

		abreConexao();

		$dados = selectSQL("SELECT * FROM bairro");

		foreach($dados as $dado){
			
			if($bairro == $dado['identificador']){
				echo "<a class='botao-bairro-selecionado' href='?q=".$pesquisa."'>".$dado['nome']."</a>";
			}else{
				echo "<a class='botao-bairro' href='?q=".$pesquisa."&bairro=".$dado['identificador']."'>".$dado['nome']."</a>";
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
								<input id="input-search-form" type="text" name="q" placeholder="O que você precisa hoje?" autocomplete="off" value="<?=$pesquisa?>">
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
					<div class="corpo-reduzido flex-column">
						<div id="filter-bar">

							<?=printFiltroBairros()?>

						</div>
						<div class="mensagem-resultado">
							<span>Mostrando resultados para: <i><?=$pesquisa?></i> </span>
						</div>
						<div class="listagem">

							<?=printPesquisa()?>
							
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