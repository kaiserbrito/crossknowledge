<?php
class UsuariosController extends Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		
		$enderecosModel = $this->loadModel('enderecos', false);
		
		$this->view->usuarios = $this->getUsuarios();
		$this->view->enderecos = $enderecosModel->getEnderecos();
		
		$this->view->render('usuarios/index');
	}
	
	function getUsuarios($html = false){
		
		if($html){
			$enderecosModel = $this->loadModel('enderecos', false);
			
			$usuarios = $this->model->getUsuarios(true);
			$enderecos = $enderecosModel->getEnderecos(true);
			
			// monta enderecos
			if(!empty($enderecos)){
				$endereco_usuario = array();
				foreach($enderecos as $endereco){
					$endereco_usuario[$endereco['id_end']] 	= $endereco['logradouro'].', '.$endereco['numero_end'].', Bairro '.$endereco['bairro'].', CEP: '.$endereco['cep'];
					$input_logradouro[$endereco['id_end']] 	= '<input type="hidden" name="logradouro" 	id="logradouro" 	value="'.$endereco['logradouro'].'" />';
					$input_numero[$endereco['id_end']] 		= '<input type="hidden" name="numero_end" 		id="numero_end" 		value="'.$endereco['numero_end'].'" />';
					$input_bairro[$endereco['id_end']] 		= '<input type="hidden" name="bairro" 		id="bairro" 		value="'.$endereco['bairro'].'" />';
					$input_cep[$endereco['id_end']] 			= '<input type="hidden" name="cep" 		id="cep" 			value="'.$endereco['cep'].'" />';
				}
			}
			
			$html = '';
			$count = 0;
			foreach($usuarios as $usuario){
				$count++;
				$html .= '<tr>';
				$html .= '<td><input type="hidden" name="id_usuario" id="id_usuario" value="'.$usuario['id_usuario'].'" />#'.$count.'</td>';
				$html .= '<td>'.$usuario['nome'].'</td>';
				$html .= '<td>'.$usuario['sobrenome'].'</td>';
				$html .= '<td>';
				if(!empty($usuario['fk_usuarios_enderecos_01'])){
					$html .= 	'<input type="hidden" name="id_end" 			id="id_end" 			value="'.$usuario['fk_usuarios_enderecos_01'].'" />';
					$html .= 	'<input type="hidden" name="logradouro" 	id="logradouro" 	value="'.$endereco['logradouro'].'" />';
					$html .= 	'<input type="hidden" name="numero_end" 		id="numero_end" 		value="'.$endereco['numero_end'].'" />';
					$html .= 	'<input type="hidden" name="bairro" 		id="bairro" 		value="'.$endereco['bairro'].'" />';
					$html .= 	'<input type="hidden" name="cep" 			id="cep" 			value="'.$endereco['cep'].'" />';
					$html .= 	(isset($endereco_usuario[$usuario['fk_usuarios_enderecos_01']])) ? $endereco_usuario[$usuario['fk_usuarios_enderecos_01']] : '';
				}
				$html .= '</td>';
				$html .= '<td>';
				$html .= 	'<a href="javascript:void(0);" class="glyphicon glyphicon-edit"></a>';
				$html .= 	'<a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="return confirm(\'Tem certeza que deseja excluir?\')?userAction(\'delete\','.$usuario['id_usuario'].'):false;"></a>';
				$html .= '</td>';
				$html .= '</tr>';
			}
			echo $html;
		} else{
			$usuarios = $this->model->getUsuarios();
			return $usuarios;
		}
	}
	
	function addUsuario(){
		
		if($_POST['logradouro'] != "" && $_POST['numero'] != "" && $_POST['bairro'] != "" && $_POST['cep'] != ""){
			$logradouro 	= $_POST['logradouro'];
			$numero 		= $_POST['numero'];
			$complemento 	= $_POST['complemento'];
			$bairro 		= $_POST['bairro'];
			$cep 			= $_POST['cep'];
			
			$endereco = array('logradouro' 	=> $logradouro, 
							'numero' 		=> $numero,
							'complemento' 	=> $complemento, 
							'bairro' 		=> $bairro,
							'cep' 			=> $cep,
			);
			
			$enderecosModel = $this->loadModel('enderecos', false);
			$response1 = $enderecosModel->addEndereco($endereco);
		}
		
		$nome 		= $_POST['nome'];
		$sobrenome 	= $_POST['sobrenome'];
		
		$usuario = array('nome' 				=> $nome, 
						'sobrenome' 			=> $sobrenome,
						'fk_usuarios_enderecos_01' 	=> (!empty($response1)) ? $response1['id_end'] : null
		);
		
		$resopnse2 = $this->model->addUsuario($usuario);
		
		echo json_encode(array('msg' => 'Ok'));
	}
	
	function editUsuario(){
		
		if($_POST['logradouro'] != "" && $_POST['numero'] != "" && $_POST['bairro'] != "" && $_POST['cep'] != ""){
			$id_end 	= $_POST['id_end'];
			$logradouro 	= $_POST['logradouro'];
			$numero 		= $_POST['numero'];
			$complemento 	= $_POST['complemento'];
			$bairro 		= $_POST['bairro'];
			$cep 			= $_POST['cep'];
			
			$endereco = array('id_end' 	=> $id_end, 
							'logradouro' 		=> $logradouro, 
							'numero' 			=> $numero,
							'complemento' 		=> $complemento, 
							'bairro' 			=> $bairro,
							'cep' 				=> $cep,
			);
			
			$enderecosModel = $this->loadModel('enderecos', false);
			$response1 = $enderecosModel->editEndereco($endereco);
		}elseif($_POST['id_end'] != ""){
			$id_end 	= $_POST['id_end'];
			$enderecosModel = $this->loadModel('enderecos', false);
			$response1 = $enderecosModel->delEndereco($id_end);
		}
		
		$id_usuario = $_POST['id_usuario'];
		$nome 		= $_POST['nome'];
		$sobrenome 	= $_POST['sobrenome'];
		
		$usuario = array('id_usuario' => $id_usuario, 
						'nome' => $nome, 
						'sobrenome' => $sobrenome,
						'fk_usuarios_enderecos_01' 	=> (!empty($response1)) ? $response1['id_end'] : null
		);
		
		$resopnse2 = $this->model->editUsuario($usuario);
		
		echo json_encode(array('msg' => 'Ok'));
	}
	
	function delUsuario(){
		
		$id_usuario = $_POST['id_usuario'];
		$usuario = $this->model->getUsuario($id_usuario, true);
		
		if(!empty($usuario['fk_usuarios_enderecos_01'])){
			$enderecosModel = $this->loadModel('enderecos', false);
			$response1 = $enderecosModel->delEndereco($usuario['fk_usuarios_enderecos_01']);
		}
		
		$resopnse2 = $this->model->delUsuario($id_usuario);
		
		echo json_encode(array('msg' => 'ok'));
	}
}