<?php
require '../../library/db/BaseDB.php';
require '../../model/UsuarioModel.php';
$populateForm['error'] = '';
$populateForm['success'] = '';
$id_usuario = $_POST['id_usuario'];
if(!empty($id_usuario)){
    $usuarioModel = new UsuarioModel();
   
    try {
       if($usuarioModel->remove($id_usuario)){
          $populateForm['success'] = 'Sucesso na operação.'; 
       }else{
          $populateForm['error'] = 'Falha na operação.';   
       }
    } catch (Exception $ex) {
        $populateForm['error'] = 'Falha na operação:'.$ex->getMessage();  
    }
}else{
   $populateForm['error'] = 'Falha na operação.';   
}

echo json_encode($populateForm);