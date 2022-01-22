<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;

class AuthfastPermissionEntity extends MongoEntity
{
	const TABLE = 'authfast_permission';
	protected $_id;
	protected $authfast_id;
	protected $module_id;
	protected $events;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = Number::intNull($authfastId);
		return $this;
	}
	public function getAuthfastId()
	{
		return $this->authfast_id;
	}
	public function setModuleId($moduleId)
	{
		$this->module_id = Number::intNull($moduleId);
		return $this;
	}
	public function getModuleId()
	{
		return $this->module_id;
	}
	public function setEvents(array $events)
	{
		$this->events = $events;
		return $this;
	}
	public function getEvents()
	{
		if (is_null($this->events)) {
			$this->events = [];
		}
		return $this->events;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'authfast_id' => $this->getAuthfastId(),
			'module_id' => $this->getModuleId(),
			'events' => $this->getEvents()
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionModuleEntity
	 */
	private $module;

	/**
	 * Get undocumented variable
	 *
	 * @return  PermissionModuleEntity
	 */
	public function getModule($refresh = false, $cls = PermissionModuleEntity::class)
	{
		if (!$this->module || $refresh) {
			$this->module = PermissionModuleRepository::byId($this->module_id, $cls);
		}
		return $this->module;
	}

	/**
	 * Undocumented variable
	 *
	 * @var AuthfastEntity
	 */
	private $authfast;

	/**
	 * Undocumented function
	 *
	 * @return AuthfastEntity
	 */
	public function getAuthfast($refresh = false, $cls = AuthfastEntity::class)
	{
		if (!$this->authfast || $refresh) {
			$this->authfast = AuthfastRepository::byId($this->authfast_id, $cls);
		}
		return $this->authfast;
	}
}
