<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class PermissionLevelEntity extends MongoEntity
{
	const TABLE = 'permission_level';
	protected $_id;
	protected $name;
	protected $level;
	protected $created_at;
	protected $updated_at;
	protected $trash;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function setName($name)
	{
		$this->name = Strings::null($name);
		return $this;
	}
	public function getName()
	{
		return $this->name;
	}
	public function setLevel($level)
	{
		$this->level = Number::intNull($level);
		return $this;
	}
	public function getLevel()
	{
		return $this->level;
	}
	public function setCreatedAt($createdAt)
	{
		if (is_string($createdAt)) {
			$createdAt = strtotime($createdAt);
		}
		$this->created_at = Number::intNull($createdAt);
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
		return $this->created_at;
	}
	public function setUpdatedAt($updatedAt)
	{
		if (is_string($updatedAt)) {
			$updatedAt = strtotime($updatedAt);
		}
		$this->updated_at = Number::intNull($updatedAt);
		return $this;
	}
	public function getUpdatedAt()
	{
		if (!is_null($this->updated_at)) {
			if (is_string($this->updated_at)) {
				$this->updated_at = strtotime($this->updated_at);
			}
		}
		return $this->updated_at;
	}
	public function setTrash($trash)
	{
		$this->trash = Boolean::null($trash);
		return $this;
	}
	public function getTrash()
	{
		if (is_null($this->trash)) {
			$this->trash = false;
		}
		return $this->trash;
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
