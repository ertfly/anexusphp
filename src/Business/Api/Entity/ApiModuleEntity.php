<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use Core\Tools\Boolean;

class ApiModuleEntity extends MongoEntity
{
	const TABLE = 'api_module';
	protected $_id;
	protected $description;
	protected $quantity;
	protected $sdk;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return Number::intNull($this->_id);
	}
	public function setDescription($description)
	{
		$this->description = Strings::null($description);
		return $this;
	}
	public function getDescription()
	{
		return Strings::null($this->description);
	}
	public function setQuantity($quantity)
	{
		$this->quantity = Number::intNull($quantity);
		return $this;
	}
	public function getQuantity()
	{
		return Number::intNull($this->quantity);
	}
	public function getSdk()
	{
		if (is_null($this->sdk)) {
			$this->sdk = false;
		}
		return Boolean::null($this->sdk);
	}
	public function setSdk($sdk)
	{
		$this->sdk = Boolean::null($sdk);

		return $this;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'description' => $this->getDescription(),
			'quantity' => $this->getQuantity(),
			'sdk' => $this->getSdk(),
		);
	}
}
