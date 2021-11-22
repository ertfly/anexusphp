<?php

namespace Core;

abstract class MongoEntity
{
    abstract public function getId();
    abstract public function toArray();

    public function insert($db)
    {
        $collection = static::TABLE;
        $db->$collection->insertOne($this->toArray());
        return;
    }

    public function update($db)
    {
        $collection = static::TABLE;
        $db->$collection->updateOne([
            '_id' => $this->getId(),
        ], [
            '$set' => $this->toArray(),
        ]);
    }

    public function delete($db)
    {
        $collection = static::TABLE;
        $db->$collection->updateOne([
            '_id' => $this->getId(),
        ], [
            '$set' => ['trash' => true],
        ]);
    }

    public function destroy($db)
    {
        $collection = static::TABLE;
        $db->$collection->deleteOne([
            '_id' => $this->getId(),
        ]);
    }

    public function fromJson(array $json)
    {
        foreach ($json as $f => $v) {
            $this->$f = $v;
        }
    }
}
