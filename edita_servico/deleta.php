<?php
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";


	checaSessao();

	$iduser = $_SESSION["userid"];
	$id_serv = $_GET["id_serv"];

	//checa para ver se o usuário realmente é dono do serviço

	$dados = selectFirstSQL("SELECT b.titulo, b.descricao_servico, b.fotopath, b.estrelas as estrelas_serv, b.totavaliacoes as totavaliacoes FROM usuario as a 
		INNER JOIN servico as b ON a.identificador = b.idusuario AND a.identificador = $iduser AND b.identificador = $id_serv");

	if(empty($dados))
	{
		header("Location: /orginfo/selfprofile/");
		exit();
	}

	$retorno = deleteSQL("DELETE FROM servico WHERE identificador = $id_serv");

	if($retorno){
		extract($dados);
		unlink($imgservpath.$fotopath); //função que apaga arquivo
    	updateSQL("UPDATE usuario SET estrelas = estrelas - $estrelas_serv, totavaliacoes = totavaliacoes - $totavaliacoes WHERE identificador = $iduser");
    }

	header("Location: /orginfo/selfprofile/");

?>