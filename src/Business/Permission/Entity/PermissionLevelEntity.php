<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\MongoEntity;

class PermissionLevelEntity extends MongoEntity
{
	const TABLE = 'permission_level';
	private $_id;
	private $name;
	private $level;
	private $created_at;
	private $updated_at;
	private $trash;
	public function setId($id)
	{
		$this->_id = intval($id);
		return $this;
	}
	public function getId()
	{
		if (!is_null($this->_id)) {
			$this->_id = intval($this->_id);
		}
		return $this->_id;
	}
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setLevel($level)
	{
		$this->level = intval($level);
		return $this;
	}
	public function getLevel()
	{
		if (!is_null($this->level)) {
			$this->level = intval($this->level);
		}
		return $this->level;
	}
	public function setCreatedAt($createdAt)
	{
		if (is_string($createdAt)) {
			$createdAt = strtotime($createdAt);
		}
		$this->created_at = intval($createdAt);
		return $this;
	}
	public function getCreatedAt()
	{
		if (is_null($this->created_at)) {
			$this->created_at = strtotime(date('Y-m-d H:i:s'));
		}
		if (is_string($this->created_at)) {
			$this->created_at = strtotime($this->created_at);
		}
		return intval($this->created_at);
	}
	public function setUpdatedAt($updatedAt)
	{
		if (is_string($updatedAt)) {
			$updatedAt = strtotime($updatedAt);
		}
		$this->updated_at = intval($updatedAt);
		return $this;
	}
	public function getUpdatedAt()
	{
		if (!is_null($this->updated_at)) {
			if (is_string($this->updated_at)) {
				$this->updated_at = strtotime($this->updated_at);
			}
			$this->updated_at = intval($this->updated_at);
		}
		return $this->updated_at;
	}
	public function setTrash($trash)
	{
		$this->trash = boolval($trash);
		return $this;
	}
	public function getTrash()
	{
		if (is_null($this->trash)) {
			$this->trash = false;
		}
		return boolval($this->trash);
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'name' => $this->getName(),
			'level' => $this->getLevel(),
			'created_at' => $this->getCreatedAt(),
			'updated_at' => $this->getUpdatedAt(),
			'trash' => $this->getTrash()
		);
	}
}
