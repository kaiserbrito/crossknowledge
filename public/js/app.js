var preencheFormEdit = function(){
	var id_usuario = $(this).parents('tr').find('#id_usuario').val();
	var id_end = $(this).parents('tr').find('#id_end').val();
	var cols = $(this).parents('tr').find('td');
	var logradouro = $(this).parents('tr').find('#logradouro').val();
	var numero = $(this).parents('tr').find('#numero').val();
	var bairro = $(this).parents('tr').find('#bairro').val();
	var cep = $(this).parents('tr').find('#cep').val();
	
	$('#idEditUsuario').val(id_usuario);
	$('#idEditEndereco').val(id_end);
	$('#nomeEdit').val(cols[1].innerHTML);
	$('#sobrenomeEdit').val(cols[2].innerHTML);
	$('#logradouroEdit').val(logradouro);
	$('#numeroEdit').val(numero);
	$('#bairroEdit').val(bairro);
	$('#cepEdit').val(cep);
	
	$('#formEdit').slideDown();
}

var validation_inputs = function(){
	$('#cep').mask('99999-999');
}

function getUsuarios(){
    $.ajax({
        type: 'POST',
        url: 'usuarios/getUsuarios/1',
        success:function(html){
            $('#userData').html(html);
			$('.glyphicon-edit').click(preencheFormEdit);
			validation_inputs();
        }
    });
}

function userAction(type,id){
    id = (typeof id == "undefined")?'':id;
    var statusArr = {add:"adicionados",edit:"atualizados",delete:"removidos"};
    var userData = '';
	var url = '';
    if (type == 'add') {
		url = 'usuarios/addUsuario';
        userData = $("#addForm").find('.form').serialize()+'&action_type='+type;
    }else if (type == 'edit'){
		url = 'usuarios/editUsuario';
        userData = $("#editForm").find('.form').serialize()+'&action_type='+type;
    }else{
		url = 'usuarios/delUsuario';
        userData = 'action_type='+type+'&id_usuario='+id;
    }
	
    $.ajax({
        type: 'POST',
        url: url,
        data: userData,
		dataType:'JSON',
        success:function(response){
            if(response.msg == 'ok'){
                alert('Os dados do Usuario foram '+statusArr[type]+' com sucesso.');
                getUsuarios();
                $('.form')[0].reset();
                $('.formData').slideUp();
            }else{
                alert('Ocorreu um erro. Tente novamente depois.');
            }
        }
    });
}

// onready
$( document ).ready(function() {
	// preenche form de editar
	$('.glyphicon-edit').click(preencheFormEdit);
	validation_inputs();
});