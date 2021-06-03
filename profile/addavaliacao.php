<?php
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";


	checaSessao();

	$id = $_SESSION["userid"];

	abreConexao();

	if (mysqli_connect_errno()) die();		//caso tenha erro finaliza

	if(isset($_POST["submit"]) && isset($_GET["id_perfil"]) && isset($_GET["id_serv"])) {

		$id_serv = $_GET["id_serv"];
		$id_perfil = $_GET["id_perfil"];

	    extract($_POST);

	    $retorno = insertSQL("INSERT INTO avaliacao (idservico, idusuario, comentario, estrelas, preco) VALUES ($id_serv, $id, '$comentario', $estrelas, $preco)");

	    if($retorno){
	    	$retorno = updateSQL("UPDATE servico SET estrelas = estrelas + $estrelas, preco = preco + $preco, totavaliacoes = totavaliacoes + 1 WHERE identificador = $id_serv");

	    	if($retorno){
	    		updateSQL("UPDATE usuario SET estrelas = estrelas + $estrelas, totavaliacoes = totavaliacoes + 1 WHERE identificador = $id_perfil");
	    	}
	    }
	}

	fechaConexao();

	if(!empty($id_perfil))
		header("Location: /orginfo/profile?id=".$id_perfil);
	else
		header("Location: /orginfo/");
?>
