<?php
require '../../library/db/BaseDB.php';
require '../../model/UsuarioModel.php';

$dataUsuario = array();
$id_usuario = $_POST['id_usuario'];
if(!empty($id_usuario)){
    $usuarioModel = new UsuarioModel();
   
    try {
       $dataUsuario = $usuarioModel->findById($id_usuario);
    } catch (Exception $ex) {
        echo "Falha na busca:".$ex->getMessage();
    }
}

echo json_encode($dataUsuario);