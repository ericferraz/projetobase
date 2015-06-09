<?php

class UsuarioModel extends BaseDB {

    protected $tabela = "tbusuario";
    protected $chaveprimaria = "id_usuario";

    public function getDataGrid($params = null) {
        $query = "SELECT * FROM {$this->tabela} WHERE 1=1 ";

        if (!empty($params['tx_nome'])) {
            $query.="AND tx_nome LIKE '%{$params['tx_nome']}%' ";
        }

        if (!empty($params['id_usuario'])) {
            $query.="AND id_usuario = {$params['id_usuario']} ";
        }

        return $this->getConection()->query($query)->fetchAll();
    }

}
