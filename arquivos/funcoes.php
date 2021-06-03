<?php 
	include $_SERVER['DOCUMENT_ROOT']."/orginfo/arquivos/config.php";

	function iniciaSessao($id){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$_SESSION["userid"] = $id;
	}

	function finalizaSessao(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		unset($_SESSION["userid"]);
	}

	function getProfileHeader(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}


		if(isset($_SESSION["userid"])){
			$id = $_SESSION["userid"];
			$dados = selectFirstSQL("SELECT fotopath FROM usuario WHERE identificador = $id");
			global $imgpathRedux;
			global $imgpath;

			echo "<div id='botoes-header'>
					<a href='/orginfo/selfprofile' id='ofertar-servico'>Ofertar Serviço</a>
				</div>
				<div id='header-profile'>
					<a href='/orginfo/selfprofile'>
						<img id='header-profile-image' src=".$imgpathRedux.$dados["fotopath"]."?".filemtime($imgpath.$dados["fotopath"]).">
					</a>
				</div>";
		}else{
			echo "<div id='botao-login'>
					<a href='/orginfo/login'>Entrar</a>
				</div>";
		}

	}
	
	function checaSessao(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if(empty($_SESSION["userid"]))
		{
			session_destroy(); //fecha a sessão vazia de cima, meio inútil, mas sla né
			header("Location: /orginfo/"); //de volta ao início
			exit(); //para de rodar o script
		}
	}

	function cropimg($path){
		global $limgsize;
		$im = imagecreatefromstring(file_get_contents($path)); //php abre a imagem 
		
		$sizex = imagesx($im); //tamanhos da imagem
		$sizey = imagesy($im);
		$centroX = round($sizex / 2); //aproximadamente o centro(talvez tenha offset de 1 pixel)
		$centroY = round($sizey / 2);

		$x=0; //ponto onde começa o "retângulo de crop"
		$y=0; 
		$wid=$sizex;
		$hei=$sizey;
		
		if($sizex > $sizey){
			$cropqt = round(($sizex-$sizey)/2);

			$x = $cropqt;
			$wid = 2*($centroX - $x);
			$hei = $wid;
		}else if($sizex < $sizey){ 
			$cropqt = round(($sizey-$sizex)/2);//tamanho do q quero remover, dividir por 2, porque metade é acima do centro e metade abaixo
			$y = $cropqt;
			$hei = 2*($centroY - $y);
			$wid = $hei;
		}


	    $crop = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $wid, 'height' => $hei]);
	    if(!empty($crop))
	    {
	        $partes = pathinfo($path);
	        if($wid > $limgsize)
	        {
	        	$scale = imagescale($crop, $limgsize, $limgsize, IMG_BICUBIC_FIXED);
	        	imagejpeg($scale,$partes["dirname"]."/".$partes["filename"].".jpg");
	        	imagedestroy($scale);
	        }else{
	        	imagejpeg($crop,$partes["dirname"]."/".$partes["filename"].".jpg");
	        }
	        
	        imagedestroy($crop);
	    }
	    imagedestroy($im);
	}

	function cropimgServ($path){
		global $limgsizeserv;
		global $imgservprop;
		$im = imagecreatefromstring(file_get_contents($path)); //php abre a imagem 
		
		$sizex = imagesx($im); //tamanhos da imagem
		$sizey = imagesy($im);
		$centroX = round($sizex / 2); //aproximadamente o centro(talvez tenha offset de 1 pixel)
		$centroY = round($sizey / 2);

		$x=0; //ponto onde começa o "retângulo de crop"
		$y=0; 
		$wid=$sizex;
		$hei=$sizey;
		
		if(($sizex/$sizey) > $imgservprop){
			$targx = $sizey * $imgservprop; //tamando ideal do x é y * proporção ideal
			$cropqt = round(($sizex-$targx)/2);

			$x = $cropqt;
			$wid = 2*($centroX - $x);
			
		
		}else if(($sizex/$sizey) < $imgservprop){ 
			$targy = $sizex/$imgservprop; //tamando ideal do y é x/proporção ideal
			$cropqt = round(($sizey-$targy)/2);//tamanho do q quero remover, dividir por 2, porque metade é acima do centro e metade abaixo
			$y = $cropqt;
			$hei = 2*($centroY - $y);
		}
		
		
		

	    $crop = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $wid, 'height' => $hei]);
	    if(!empty($crop))
	    {
	        $partes = pathinfo($path);
	        if($wid > $limgsizeserv)
	        {
	        	$scale = imagescale($crop, $limgsizeserv, ($limgsizeserv/$imgservprop), IMG_BICUBIC_FIXED);
	        	imagejpeg($scale,$partes["dirname"]."/".$partes["filename"].".jpg");
	        	imagedestroy($scale);
	        }else{
	        	echo $sizex = imagesx($crop);
	        	imagejpeg($crop,$partes["dirname"]."/".$partes["filename"].".jpg");
	        }
	        
	        imagedestroy($crop);
	    }
	    imagedestroy($im);
	}