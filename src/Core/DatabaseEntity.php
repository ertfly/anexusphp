<?php

namespace AnexusPHP\Core;

use Medoo\Medoo;

abstract class DatabaseEntity
{

    abstract public function setId($id);

    abstract public function getId();

    abstract public function toArray();

    public function save(Medoo $db, $where = [])
    {
        $tabela = static::TABELA;
        if (!$this->getId()) {
            $db->insert($tabela, $this->toArray());
            $id = $db->id();
            $this->setId($id);
            return;
        }

        if(count($where)==0){
            $where['id'] = $this->getId();
        }
        $db->update($tabela, $this->toArray(), $where);
    }

    public function delete(Medoo $db, $where = [])
    {
        if(count($where)==0){
            $where['id'] = $this->getId();
        }
        $tabela = static::TABELA;
        if (!$this->getId()) {
            return;
        }
        $db->update($tabela, ['lixo' => true], $where);
    }

    public function destroy(Medoo $db, $where = [])
    {
        if(count($where)==0){
            $where['id'] = $this->getId();
        }
        $tabela = static::TABELA;
        if (!$this->getId()) {
            return;
        }
        $db->delete($tabela, $where);
    }

    public function fromJson(array $json)
    {
        foreach ($json as $campo => $valor) {
            $c = $campo;
            $this->$c = $valor;
        }
    }
}
