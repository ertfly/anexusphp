<?php

namespace AnexusPHP\Tools;

use Medoo\Medoo;

abstract class DatabaseEntity
{

    abstract public function setId($id);

    abstract public function getId();

    abstract public function toArray();

    public function save(Medoo $db)
    {
        $tabela = static::TABELA;
        if (!$this->getId()) {
            $db->insert($tabela, $this->toArray());
            $id = $db->id();
            $this->setId($id);
            return;
        }
        $db->update($tabela, $this->toArray(), ['id' => $this->getId()]);
    }

    public function delete(Medoo $db)
    {
        $tabela = static::TABELA;
        if (!$this->getId()) {
            return;
        }
        $db->update($tabela, ['lixo' => true], ['id' => $this->getId()]);
    }

    public function destroy(Medoo $db)
    {
        $tabela = static::TABELA;
        if (!$this->getId()) {
            return;
        }
        $db->delete($tabela, ['id' => $this->getId()]);
    }

    public function fromJson(array $json)
    {
        foreach ($json as $campo => $valor) {
            $c = $campo;
            $this->$c = $valor;
        }
    }
}
