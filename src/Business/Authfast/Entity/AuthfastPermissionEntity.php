<?php

namespace PequiPHP\Business\Authfast\Entity;

use PequiPHP\Business\Authfast\Repository\AuthfastRepository;
use PequiPHP\Business\Permission\Entity\PermissionModuleEntity;
use PequiPHP\Business\Permission\Repository\PermissionModuleRepository;
use PequiPHP\Core\MongoEntity;

class AuthfastPermissionEntity extends MongoEntity
{
	const TABLE = 'authfast_permission';
	private $_id;
	private $authfast_id;
	private $module_id;
	private $events;
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
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = intval($authfastId);
		return $this;
	}
	public function getAuthfastId()
	{
		if (!is_null($this->authfast_id)) {
			$this->authfast_id = intval($this->authfast_id);
		}
		return $this->authfast_id;
	}
	public function setModuleId($moduleId)
	{
		$this->module_id = intval($moduleId);
		return $this;
	}
	public function getModuleId()
	{
		if (!is_null($this->module_id)) {
			$this->module_id = intval($this->module_id);
		}
		return $this->module_id;
	}
	public function setEvents($events)
	{
		$this->events = $events;
		return $this;
	}
	public function getEvents()
	{
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
