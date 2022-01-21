<?php

namespace AnexusPHP\Business\Api\Entity;

use AnexusPHP\Business\Api\Repository\ApiModuleRepository;
use AnexusPHP\Core\MongoEntity;

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
	public function setApiModuleId($apiModuleId)
	{
		$this->api_module_id = intval($apiModuleId);
		return $this;
	}
	public function getApiModuleId()
	{
		if (!is_null($this->api_module_id)) {
			$this->api_module_id = intval($this->api_module_id);
		}
		return $this->api_module_id;
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
	public function setDefinition(array $definition)
	{
		$this->definition = $definition;
		return $this;
	}
	public function getDefinition()
	{
		return $this->definition;
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
		if (!$this->definitions) {
			$this->definitions = [];
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
