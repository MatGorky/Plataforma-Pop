<?php
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";


	checaSessao();

	$iduser = $_SESSION["userid"];
	$id_serv = $_GET["id_serv"];
	//checa para ver se o usuário realmente é dono do serviço
	$dados = selectFirstSQL("SELECT b.titulo, b.descricao_servico FROM usuario as a INNER JOIN servico as b ON a.identificador = b.idusuario AND a.identificador = $iduser AND b.identificador = $id_serv");
	if(empty($dados))
	{
		header("Location: /orginfo/selfprofile/");
		exit();
	}

	if(isset($_POST["submit"])){
		extract($_POST);
		
		abreConexao();
		if (mysqli_connect_errno()) die();

		
		updateSQL("UPDATE servico SET titulo = '$titulo', descricao_servico = '$descricao' WHERE idusuario = $iduser AND identificador = $id_serv");
		

		if($_FILES["imagem"]["name"] != ""){
		
			$img = basename($_FILES["imagem"]["name"]); 	//nome original da imagem, serve para adquirir a extensão
			$tipo = strtolower(pathinfo($img, PATHINFO_EXTENSION)); 		//tipo de arquivo (extensão)
			$tiposPermitidos = array('jpg','png','jpeg');					//apenas imagens

			if(in_array($tipo, $tiposPermitidos)){

			    $foto = "servico_" . $id_serv . "." . $tipo; 	
			    $caminho = $imgservpath.$foto;

			     if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)){		
			        updateSQL("UPDATE servico SET fotopath = '$foto' WHERE identificador = $id_serv");	  
			        cropimgServ($caminho);
			        
			    }else{
			        die();
			    }
			}else{
			    echo "nao permitido";
		        die();
			}
		}
		fechaConexao();		    
	}


	header("Location: /orginfo/selfprofile/");
?>
