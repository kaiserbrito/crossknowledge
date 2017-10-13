<div class="row">
	<div class="panel panel-default users-content">
		<div class="panel-heading">Usuarios <a href="javascript:void(0);" class="glyphicon glyphicon-plus" id="addLink" onclick="javascript:$('#addForm').slideToggle();"></a></div>
		<div class="panel-body none formData" id="addForm">
			<h2 id="actionLabel">Adicionar</h2>
			<form class="form" id="userForm">
				<div class="form-group">
					<label>Nome</label>
					<input type="text" class="form-control" name="nome" maxlength="40" id="nome"/>
				</div>
				<div class="form-group">
					<label>Sobrenome</label>
					<input type="text" class="form-control" name="sobrenome" maxlength="40" id="sobrenome"/>
				</div>
				<fieldset>
					<legend>Endereço</legend>
					<div class="form-group" style="float:left;width:45%;">
						<label>Logradouro</label>
						<input type="text" class="form-control" name="logradouro" maxlength="40" id="logradouro"/>
					</div>
					<div class="form-group" style="float:left;margin:0 5%;width:20%;">
						<label>Número</label>
						<input type="text" class="form-control" name="numero" maxlength="8" id="numero"/>
					</div>
					<div class="form-group" style="float:left;width:20%;">
						<label>Complemento</label>
						<input type="text" class="form-control" name="complemento" maxlength="8" id="complemento"/>
					</div>
					<div class="form-group" style="float:left;margin-right:5%;width:45%;">
						<label>Bairro</label>
						<input type="text" class="form-control" name="bairro" maxlength="40" id="bairro"/>
					</div>
					<div class="form-group" style="float:left;width:20%;">
						<label>CEP</label>
						<input type="text" class="form-control" name="cep" maxlength="9" id="cep"/>
					</div>
				</fieldset>
				<a href="javascript:void(0);" class="btn btn-success" onclick="userAction('add')">Adicionar</a>
				<a href="javascript:void(0);" class="btn btn-warning" onclick="$('#addForm').slideUp();">Cancelar</a>
			</form>
		</div>
		<div class="panel-body none formData" id="editForm">
			<h2 id="actionLabel">Editar</h2>
			<form class="form" id="userForm">
				<div class="form-group">
					<label>Nome</label>
					<input type="text" class="form-control" name="nome" id="nomeEdit"/>
				</div>
				<div class="form-group">
					<label>Sobrenome</label>
					<input type="text" class="form-control" name="sobrenome" id="sobrenomeEdit"/>
				</div>
				<fieldset>
					<legend>Endereço</legend>
					<div class="form-group" style="float:left;width:45%;">
						<label>Logradouro</label>
						<input type="text" class="form-control" name="logradouro" id="logradouroEdit"/>
					</div>
					<div class="form-group" style="float:left;margin:0 5%;width:20%;">
						<label>Número</label>
						<input type="text" class="form-control" name="numero" id="numeroEdit"/>
					</div>
					<div class="form-group" style="float:left;width:20%;">
						<label>Complemento</label>
						<input type="text" class="form-control" name="complemento" id="complementoEdit"/>
					</div>
					<div class="form-group" style="float:left;margin-right:5%;width:45%;">
						<label>Bairro</label>
						<input type="text" class="form-control" name="bairro" id="bairroEdit"/>
					</div>
					<div class="form-group" style="float:left;width:20%;">
						<label>CEP</label>
						<input type="text" class="form-control" name="cep" id="cepEdit"/>
					</div>
				</fieldset>
				<input type="hidden" class="form-control" name="id_usuario" id="idEditUsuario"/>
				<input type="hidden" class="form-control" name="id_end" id="idEditEndereco"/>
				<a href="javascript:void(0);" class="btn btn-success" onclick="userAction('edit')">Atualizar</a>
				<a href="javascript:void(0);" class="btn btn-warning" onclick="$('#editForm').slideUp();">Cancelar</a>
			</form>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Nome</th>
					<th>Sobrenome</th>
					<th>Endereço</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody id="userData">
				<?php
					$usuarios = $this->usuarios;
					$usuarios = json_decode($usuarios, true);
					
					$enderecos = $this->enderecos;
					$enderecos = json_decode($enderecos, true);
					
					// monta enderecos
					if(!empty($enderecos)){
						$endereco_usuario = array();
						foreach($enderecos as $endereco){
							$endereco_usuario[$endereco['id_end']] 	= $endereco['id_end'].', '.$endereco['numero'].', Bairro '.$endereco['bairro'].', CEP: '.$endereco['cep'];
							$input_logradouro[$endereco['id_end']] 	= '<input type="hidden" name="id_end" 	id="id_end" 	value="'.$endereco['id_end'].'" />';
							$input_numero[$endereco['id_end']] 		= '<input type="hidden" name="numero" 		id="numero" 		value="'.$endereco['numero'].'" />';
							$input_bairro[$endereco['id_end']] 		= '<input type="hidden" name="bairro" 		id="bairro" 		value="'.$endereco['bairro'].'" />';
							$input_cep[$endereco['id_end']] 			= '<input type="hidden" name="cep" 		id="cep" 			value="'.$endereco['cep'].'" />';
						}
					}
					
					if(!empty($usuarios)): $count = 0; foreach($usuarios as $usuario): $count++;
				?>
				<tr>
					<td>
						<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario['id_usuario']; ?>" />
						<input type="hidden" name="id_end" id="id_end" value="<?php echo $usuario['fk_usuarios_enderecos_01']; ?>" />
						<?php echo '#'.$count; ?>
					</td>
					<td><?php echo $usuario['nome']; ?></td>
					<td><?php echo $usuario['sobrenome']; ?></td>
					<td>
						<?php 
							if(!empty($usuario['fk_usuarios_enderecos_01'])){
								echo $input_logradouro[$usuario['fk_usuarios_enderecos_01']];
								echo $input_numero[$usuario['fk_usuarios_enderecos_01']];
								echo $input_bairro[$usuario['fk_usuarios_enderecos_01']];
								echo $input_cep[$usuario['fk_usuarios_enderecos_01']];
								echo $endereco_usuario[$usuario['fk_usuarios_enderecos_01']]; 
							}
						?>
					</td>
					<td>
						<a href="javascript:void(0);" class="glyphicon glyphicon-edit"></a>
						<a href="javascript:void(0);" class="glyphicon glyphicon-trash" onclick="return confirm('Tem certeza que deseja excluir?')?userAction('delete',<?php echo $usuario['id_usuario']; ?>):false;"></a>
					</td>
				</tr>
				<?php endforeach; else: ?>
				<tr><td colspan="5">Nada encontrado</td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>