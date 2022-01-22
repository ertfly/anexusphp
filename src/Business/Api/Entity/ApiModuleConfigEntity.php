<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Business\Api\Repository\ApiModuleRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;
use AnexusPHP\Core\Tools\Boolean;

class ApiModuleConfigEntity extends MongoEntity
{
	const TABLE = 'api_module_config';
	protected $_id;
	protected $api_module_id;
	protected $description;
	protected $definition;
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
	public function setApiModuleId($apiModuleId)
	{
		$this->api_module_id = Number::intNull($apiModuleId);
		return $this;
	}
	public function getApiModuleId()
	{
		return $this->api_module_id;
	}
	public function setDescription($description)
	{
		$this->description = Strings::null($description);
		return $this;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function setDefinition(array $definition)
	{
		$this->definition = $definition;
		return $this;
	}
	public function getDefinition()
	{
		if (is_null($this->definition)) {
			$this->definition = [];
		}
		return $this->definition;
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
			'api_module_id' => $this->getApiModuleId(),
			'description' => $this->getDescription(),
			'definition' => $this->getDefinition(),
			'trash' => $this->getTrash()
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	private $definitions;

	/**
	 * Get undocumented variable
	 *
	 * @return  mixed
	 */
	public function getDefinitionByKey($key, $defaultValue = null)
	{
		if (is_null($this->definitions)) {
			$this->definitions = $this->getDefinition();
		}
		if (!isset($this->definitions[$key])) {
			return $defaultValue;
		}
		if (is_string($this->definitions[$key]) && trim($this->definitions[$key]) == '') {
			return $defaultValue;
		}
		return $this->definitions[$key];
	}

	/**
	 * Undocumented variable
	 *
	 * @var ApiModuleEntity
	 */
	private $apiModule;

	/**
	 * Get undocumented variable
	 *
	 * @return  ApiModuleEntity
	 */
	public function getApiModule()
	{
		if (is_null($this->apiModule)) {
			$this->apiModule = ApiModuleRepository::byId($this->api_module_id);
		}
		return $this->apiModule;
	}
}
