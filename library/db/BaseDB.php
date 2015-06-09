<?php

 class BaseDB {

    private $driver = "mysql";
    private $host = "localhost";
    private $dataBase = "baseeteste";
    private $usuario = "root";
    private $senha = "123456";
    private $conexao = null;

    public function getConection() {

        if (empty($this->conexao)) {
            try {
                $this->conexao = new PDO("{$this->driver}:host={$this->host};dbname={$this->dataBase}", "{$this->usuario}", "{$this->senha}");
                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                throw new Exception("Possivel problema ao adquirir uma conexão." . $e);
            }
        }

        return $this->conexao;
    }

    /**
     * save verifica se no array associativo passado
     * tem a chave primária e não está vazia
     * se tiver, então realiza o update, se não realiza o insert
     * em todas as situações a chave primária é retornada
     * @param type $data, um array associativo, onde
     * as chaves possum o mesmo nome das colunas da tabela
     * e o valor será inserido nas colunas da mesma
     * @throws Exception
     */
    public function save($data) {
        $chavePrimaria = $this->getChavePrimaria();
        $arrayKeys = array_keys($data);
        $arrayValues = array_values($data);
        $operacao = 'I';
        if (in_array($chavePrimaria, $arrayKeys) && !empty($arrayValues[0])) {
            $operacao = 'U';
            $valorChavePrimaria = $arrayValues[0];
            unset($arrayKeys[0]);
            unset($arrayValues[0]);
        }
        $qtd = count($arrayKeys);

        try {
            $query = implode("=?,", $arrayKeys);

            if ($qtd > 1) {
                $query.="=?";
            }

            if ($operacao == 'I') {
                $stringSql = "INSERT INTO {$this->tabela} SET {$query} ";
                $this->getConection()->prepare($stringSql)->execute($arrayValues);
                return $this->getConection()->lastInsertId();
            } else {
                $stringSql = "UPDATE  {$this->tabela} SET {$query} WHERE {$chavePrimaria}=? ";

                $novoArray = $arrayValues;
                unset($arrayValues);
                $arrayValues = array();
                foreach ($novoArray as $key => $val) {
                    $arrayValues[$key - 1] = $val;
                }

                $arrayValues[$qtd] = $valorChavePrimaria;
                $this->getConection()->prepare($stringSql)->execute($arrayValues);

                return $valorChavePrimaria;
            }
        } catch (Exception $ex) {
            throw new Exception("Falha ao inserir dados:" . $ex->getMessage());
        }
    }

    /**
     * remove um registro pelo valor da
     * chave primária
     * @param type $id
     * @return type
     * @throws Exception
     */
    public function remove($id) {
        try {
            $chavePrimaria = $this->getChavePrimaria();
            $stringSql = "DELETE FROM {$this->tabela} WHERE {$chavePrimaria}=? ";
            return $this->getConection()->prepare($stringSql)->execute(array(0 => $id));
        } catch (Exception $exc) {
            throw new Exception("Falha ao remover dados:" . $ex->getMessage());
        }
    }

    public function fetchAll() {
        $stringSql = "SELECT * FROM {$this->tabela} ";
        return $this->getConection()->query($stringSql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $chavePrimaria = $this->getChavePrimaria();
        $stringSql = "SELECT * FROM {$this->tabela} WHERE {$chavePrimaria}=? ";
        $dataUsuario = $this->getConection()->prepare($stringSql);
        $dataUsuario->bindParam(1, $id, PDO::PARAM_INT);
        $dataUsuario->execute();
        return $dataUsuario->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * È possível utilizar mais de uma chave primária
     * mas nesse cenário, levo em consideração que a primeira
     * coluna da tabela é a chave primária
     * e uso somente ela
     * 
     * @return type a chave primária da tabela atual
     */
    private final function getChavePrimaria() {
        $con = $this->getConection()->query("SHOW KEYS FROM {$this->tabela} ");
        $data = $con->fetchAll();
        return $data[0]['Column_name'];
    }

}
