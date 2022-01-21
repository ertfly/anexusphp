<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;
use AnexusPHP\Core\Tools\Strings;

class AuthfastActivityEntity extends MongoEntity
{
	const TABLE = 'authfast_activity';
	protected $_id;
	protected $authfast_id;
	protected $permission_event_id;
	protected $permission_module_id;
	protected $bind_id;
	protected $bind_table;
	protected $description;
	protected $created_at;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return Number::intNull($this->_id);
	}
	public function getAuthfastId()
	{
		return Number::intNull($this->authfast_id);
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = Number::intNull($authfastId);

		return $this;
	}
	public function getPermissionEventId()
	{
		return Number::intNull($this->permission_event_id);
	}
	public function setPermissionEventId($permissionEventId)
	{
		$this->permission_event_id = Number::intNull($permissionEventId);

		return $this;
	}
	public function getPermissionModuleId()
	{
		return Number::intNull($this->permission_module_id);
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
		return Strings::null($this->bind_id);
	}
	public function getBindTable()
	{
		return Strings::null($this->bind_table);
	}
	public function setBindTable($bindTable)
	{
		$this->bind_table = Strings::null($bindTable);

		return $this;
	}
	public function getDescription()
	{
		return Strings::null($this->description);
	}
	public function setDescription($description)
	{
		$this->description = Strings::null($description);

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
	public function getCreatedAt($format = false)
	{
		if (is_null($this->created_at)) {
			$this->created_at = strtotime(date('Y-m-d H:i:s'));
		}

		if (is_string($this->created_at)) {
			$this->created_at = strtotime($this->created_at);
		}

		if ($format) {
			return date('d/m/Y H:i:s', $this->created_at);
		}

		return Number::intNull($this->created_at);
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'authfast_id' => $this->getAuthfastId(),
			'permission_event_id' => $this->getPermissionEventId(),
			'permission_module_id' => $this->getPermissionModuleId(),
			'bind_id' => $this->getBindId(),
			'bind_table' => $this->getBindTable(),
			'description' => $this->getDescription(),
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
}
