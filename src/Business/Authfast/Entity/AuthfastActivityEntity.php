<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\App\Entity\AppEntity;
use AnexusPHP\Business\App\Repository\AppRepository;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Permission\Entity\PermissionEventEntity;
use AnexusPHP\Business\Permission\Entity\PermissionModuleEntity;
use AnexusPHP\Business\Permission\Repository\PermissionEventRepository;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;

class AuthfastActivityEntity extends MongoEntity
{
	const TABLE = 'authfast_activity';
	protected $_id;
	protected $authfast_id;
	protected $app_id;
	protected $permission_event_id;
	protected $permission_module_id;
	protected $bind_id;
	protected $bind_table;
	protected $description;
	protected $last_data;
	protected $created_at;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function getAuthfastId()
	{
		return $this->authfast_id;
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = Number::intNull($authfastId);

		return $this;
	}
	public function getAppId()
	{
		return $this->app_id;
	}
	public function setAppId($appId)
	{
		$this->app_id = Number::intNull($appId);

		return $this;
	}
	public function getPermissionEventId()
	{
		return $this->permission_event_id;
	}
	public function setPermissionEventId($permissionEventId)
	{
		$this->permission_event_id = Number::intNull($permissionEventId);

		return $this;
	}
	public function getPermissionModuleId()
	{
		return $this->permission_module_id;
	}
	public function setPermissionModuleId($permissionModuleId)
	{
		$this->permission_module_id = Number::intNull($permissionModuleId);

		return $this;
	}
	public function setBindId($bindId)
	{
		$this->bind_id = Strings::null($bindId);
		return $this;
	}
	public function getBindId()
	{
		return $this->bind_id;
	}
	public function getBindTable()
	{
		return $this->bind_table;
	}
	public function setBindTable($bindTable)
	{
		$this->bind_table = Strings::null($bindTable);

		return $this;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function setDescription($description)
	{
		$this->description = Strings::null($description);

		return $this;
	}
	public function getLastData()
	{
		return $this->last_data;
	}
	public function setLastData(array $last_data)
	{
		$this->last_data = $last_data;

		return $this;
	}
	public function setCreatedAt($createdAt)
	{
		if (is_string($createdAt)) {
			$createdAt = strtotime($createdAt);
		}
		$this->created_at = Number::intNull($createdAt);
		return $this;
	}
	public function getCreatedAt($format = false, $f = 'd/m/Y H:i:s')
	{
		if (is_null($this->created_at)) {
			$this->created_at = strtotime(date('Y-m-d H:i:s'));
		}

		if (is_string($this->created_at)) {
			$this->created_at = strtotime($this->created_at);
		}

		if ($format) {
			return date($f, $this->created_at);
		}

		return $this->created_at;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'authfast_id' => $this->getAuthfastId(),
			'app_id' => $this->getAppId(),
			'permission_event_id' => $this->getPermissionEventId(),
			'permission_module_id' => $this->getPermissionModuleId(),
			'bind_id' => $this->getBindId(),
			'bind_table' => $this->getBindTable(),
			'description' => $this->getDescription(),
			'last_data' => $this->getLastData(),
			'created_at' => $this->getCreatedAt(),
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var AuthfastEntity
	 */
	private $authfast;

	/**
	 * Get undocumented variable
	 *
	 * @return  AuthfastEntity
	 */
	public function getAuthfast($refresh = false, $cls = AuthfastEntity::class)
	{
		if (!$this->authfast || $refresh) {
			$this->authfast = AuthfastRepository::byId($this->authfast_id, $cls);
		}
		return $this->authfast;
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionEventEntity
	 */
	private $permissionEvent;

	/**
	 * Get undocumented variable
	 *
	 * @return  PermissionEventEntity
	 */
	public function getPermissionEvent()
	{
		if (is_null($this->permissionEvent)) {
			$this->permissionEvent = PermissionEventRepository::byId($this->permission_event_id);
		}
		return $this->permissionEvent;
	}

	/**
	 * Undocumented variable
	 *
	 * @var PermissionModuleEntity
	 */
	private $permissionModule;

	/**
	 * Get undocumented variable
	 *
	 * @return  PermissionModuleEntity
	 */
	public function getPermissionModule()
	{
		if (is_null($this->permissionModule)) {
			$this->permissionModule = PermissionModuleRepository::byId($this->permission_module_id);
		}
		return $this->permissionModule;
	}

	/**
	 * Undocumented variable
	 *
	 * @var AppEntity
	 */
	private $app;

	/**
	 * Get undocumented variable
	 *
	 * @return  AppEntity
	 */
	public function getApp()
	{
		if (is_null($this->app)) {
			$this->app = AppRepository::byId($this->app_id);
		}
		return $this->app;
	}
}
