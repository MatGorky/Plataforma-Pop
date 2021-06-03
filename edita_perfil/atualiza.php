<?php
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/funcoes.php";
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/database.php";


	checaSessao();

	$userid = $_SESSION["userid"];

	abreConexao();

	if (mysqli_connect_errno()) die();		//caso tenha erro finaliza

	if(isset($_POST["submit"])) {
		if($_FILES["imagem"]["name"] != ""){

			$img = basename($_FILES["imagem"]["name"]); 	//nome original da imagem, serve para adquirir a extensão

			$tipo = strtolower(pathinfo($img,PATHINFO_EXTENSION)); 		//tipo de arquivo (extensão)
	    	$tiposPermitidos = array('jpg','png','jpeg');//apenas imagens

	    	if(in_array($tipo, $tiposPermitidos)){
	    		$foto = "perfil_" . $userid . "." . $tipo; 	
	    		$caminho = $imgpath . $foto;


	     		if(move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho)){  //o "tmp_name" aqui, é porque o 
	            	updateSQL("UPDATE usuario SET fotopath = '$foto' WHERE identificador = $userid");	  //php move ela pra um lugar temporário"
	            	
	            	cropimg($caminho);
	        	}else{
	        		die();
	        	}
	    	}else{
	        	echo "nao permitido";
	        	die();
	    	}

	    }

	    extract($_POST);

	    if($senha == ""){
	    	updateSQL("UPDATE usuario SET nome = '$nome', email = '$email', celular = $celular, descricao = '$descricaop', descricao_completa = '$descricaog' WHERE identificador = $userid");
	    }else{
		    $hash = password_hash($_POST["senha"], PASSWORD_DEFAULT);
	    	updateSQL("UPDATE usuario SET nome = '$nome', email = '$email', celular = $celular, senha = '$hash', descricao = '$descricaop', descricao_completa = '$descricaog' WHERE identificador = $userid");
		}

		$dados = selectSQL("SELECT * FROM bairro");

		$i = 0;

		foreach($dados as $dado){
			if(isset($_POST["bairro".$dado['identificador']])){
				$retorno = insertSQL("INSERT INTO `bairro_usuario`(`idbairro`, `idusuario`) VALUES (".$dado['identificador'].",".$userid.")");
			}else{
				deleteSQL("DELETE FROM bairro_usuario WHERE idusuario = $userid AND idbairro = ".$dado['identificador']);
			}
		}
	}


	fechaConexao();


	header("Location: /orginfo/selfprofile/");
?>
