<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\MongoEntity;

class ApiModuleEntity extends MongoEntity
{
	const TABLE = 'api_module';
	protected $_id;
	protected $description;
	protected $quantity;
	protected $register;
	protected $trash;
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
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function setQuantity($quantity)
	{
		$this->quantity = intval($quantity);
		return $this;
	}
	public function getQuantity()
	{
		if (!is_null($this->quantity)) {
			$this->quantity = intval($this->quantity);
		}
		return $this->quantity;
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
			'description' => $this->getDescription(),
			'quantity' => $this->getQuantity(),
			'trash' => $this->getTrash(),
		);
	}
	public function getRegister()
	{
		if (is_null($this->register)) {
			$this->register = false;
		}
		return boolval($this->register);
	}
	public function setRegister($register)
	{
		$this->register = boolval($register);

		return $this;
	}
}
