<?php
class EnderecosModel extends Model {
	function __construct() {
		parent::__construct();
	}
	
	function getEnderecos($array = false){
		
		$statementh = $this->db->prepare('SELECT * FROM enderecos');
		$statementh->setFetchMode(PDO::FETCH_ASSOC);
		$statementh->execute();
		$results = $statementh->fetchAll();
		
		$rows = array();
		
		foreach($results as $result) {
		  $rows[] = array_map('utf8_encode', $result);
		}
		
		return ($array == true) ? $rows : json_encode($rows);
	}
	
	function editEndereco($endereco){
		
		$statementh = $this->db->prepare('REPLACE INTO enderecos VALUES (:id_end, :logradouro, :numero, :cep, :bairro, :complemento)');
		
		$statementh->execute(array(
			':id_end' => $endereco['id_end'],
			':logradouro' 	=> utf8_decode($endereco['logradouro']),
			':numero' 		=> utf8_decode($endereco['numero']),
			':complemento' 	=> utf8_decode($endereco['complemento']),
			':bairro' 		=> utf8_decode($endereco['bairro']),
			':cep' 			=> $endereco['cep']
		));
		
		return array('id_end' => $this->db->lastInsertId());
	}
	
	function addEndereco($endereco){
		
		$statementh = $this->db->prepare('INSERT INTO enderecos (logradouro, numero, complemento, bairro, cep) VALUES (:logradouro, :numero, :complemento, :bairro, :cep)');
		
		$statementh->execute(array(
			':logradouro' 	=> utf8_decode($endereco['logradouro']),
			':numero' 		=> utf8_decode($endereco['numero']),
			':complemento' 	=> utf8_decode($endereco['complemento']),
			':bairro' 		=> utf8_decode($endereco['bairro']),
			':cep' 			=> $endereco['cep']
		));
		
		return array('id_end' => $this->db->lastInsertId());
	}
	
	function delEndereco($id_end){
		
		$statementh = $this->db->prepare('DELETE FROM enderecos WHERE id_end = "'.$id_end.'"');
		$statementh->execute();
	}
}