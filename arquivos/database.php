<?php

	$config = array (
		'APP_PREFIX' => '/orginfo',
		'DEFAULT_TIME_ZONE' => 'America/Sao_Paulo',
		'DB_HOST' => '127.0.0.1',
		'DB_USER' => 'root',
		'DB_DATABASE' => 'plataforma_pop',
		'DB_PASSWORD' => '',
	);

	function abreConexao(){
		global $config;
		global $conexao;

		if($conexao == null){
			$conexao = mysqli_connect($config["DB_HOST"], $config["DB_USER"], $config["DB_PASSWORD"], $config["DB_DATABASE"]);
		}

		mysqli_set_charset($conexao, "utf8mb4");
	}

	function fechaConexao(){
		global $config;
		global $conexao;

		mysqli_close($conexao);
		$conexao = null;
	}

	function selectFirstSQL($sql){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}

		$query = mysqli_query($conexao, $sql);
		if($query){
			if($dados = mysqli_fetch_assoc($query)) {
				return $dados;
			}
		}else{
			return null;
		}
	}

	function selectSQL($sql){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}
		
		$dados = array();
		
		$query = mysqli_query($conexao, $sql);
		if($query){
			$dado = mysqli_fetch_assoc($query);
			while($dado != null) {
				array_push($dados, $dado);

				$dado = mysqli_fetch_assoc($query);
			}
		}

		return $dados;
	}

	function updateSQL($sql){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}
		
		return mysqli_query($conexao, $sql);
	}

	function insertSQL($sql){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}
		
		return mysqli_query($conexao, $sql);
	}

	function getLastId(){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}
		
		return mysqli_insert_id($conexao);
	}

	function deleteSQL($sql){
		global $config;
		global $conexao;

		if($conexao == null){
			abreConexao();
		}
		
		return mysqli_query($conexao, $sql);
	}