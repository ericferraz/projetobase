<?php

require '../../library/db/BaseDB.php';
require '../../model/UsuarioModel.php';
$populateForm['error'] = '';
$populateForm['success'] = '';
$populateForm['usuario'] = '';

$dataUsuario = $_POST['usuario'];
if(!empty($dataUsuario)){
    $usuarioModel = new UsuarioModel();
   
    try {
        $id_usuario = $usuarioModel->save($dataUsuario);
        if(!empty($id_usuario)){
            $dataUsuario['id_usuario'] = $id_usuario;
            $populateForm['success'] = "Salvo com Sucesso.";
            $populateForm['usuario'] = $dataUsuario;
        }else{
            $populateForm['error'] = "Falha ao salvar"; 
        }
    } catch (Exception $ex) {
         $populateForm['error'] = "Falha ao salvar:".$ex->getMessage();
    }
}else{
    $populateForm['error'] = "Dados Não Informados";
}

echo json_encode($populateForm);