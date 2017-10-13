<?php
class UsuariosModel extends Model {
	function __construct() {
		parent::__construct();
	}
	
	function getPessoa($id_usuario, $array = false){
		
		$statementh = $this->db->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario');
		$statementh->setFetchMode(PDO::FETCH_ASSOC);
		$statementh->execute(array(
			':id_usuario' => $id_usuario
		));
		$result = $statementh->fetch();
		
		$rows = array_map('utf8_encode', $result);
		
		return ($array == true) ? $rows : json_encode($rows);
	}
	
	function getUsuario($array = false){
		
		$statementh = $this->db->prepare('SELECT * FROM usuarios');
		$statementh->setFetchMode(PDO::FETCH_ASSOC);
		$statementh->execute();
		$results = $statementh->fetchAll();
		
		$rows = array();
		
		foreach($results as $result) {
		  $rows[] = array_map('utf8_encode', $result);
		}
		
		return ($array == true) ? $rows : json_encode($rows);
	}
	
	function editUsuario($usuario){
		
		$statementh = $this->db->prepare('UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, fk_usuarios_enderecos_01 = :fk_usuarios_enderecos_01, modificado = NOW() WHERE id_usuario = :id_usuario');
		
		$statementh->execute(array(
			':id_usuario' 				=> $usuario['id_usuario'],
			':nome' 				=> utf8_decode($usuario['nome']),
			':sobrenome' 		=> utf8_decode($usuario['sobrenome']),
			':fk_usuarios_enderecos_01' 	=> $usuario['fk_usuarios_enderecos_01']
		));
	}
	
	function addUsuario($usuario){
		
		$statementh = $this->db->prepare('INSERT INTO usuarios (nome, sobrenome, fk_usuarios_enderecos_01) VALUES (:nome, :sobrenome, :fk_usuarios_enderecos_01)');
		
		$statementh->execute(array(
			':nome' 				=> utf8_decode($usuario['nome']),
			':sobrenome' 		=> utf8_decode($usuario['sobrenome']),
			':fk_usuarios_enderecos_01' 	=> $usuario['fk_usuarios_enderecos_01']
		));
	}
	
	function delUsuario($id_usuario){
		
		$statementh = $this->db->prepare('DELETE FROM usuarios WHERE id_usuario = "'.$id_usuario.'"');
		$statementh->execute();
	}
}