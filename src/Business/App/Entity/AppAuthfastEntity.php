<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Business\Permission\Entity\PermissionLevelEntity;
use AnexusPHP\Business\Permission\Repository\PermissionLevelRepository;
use AnexusPHP\Core\MongoEntity;
use AnexusPHP\Core\Tools\Number;

class AppAuthfastEntity extends MongoEntity
{
	const TABLE = 'app_authfast';
	protected $_id;
	protected $app_id;
	protected $authfast_id;
	protected $permission_level_id;
	public function setId($id)
	{
		$this->_id = Number::intNull($id);
		return $this;
	}
	public function getId()
	{
		return Number::intNull($this->_id);
	}
	public function setAppId($appId)
	{
		$this->app_id = Number::intNull($appId);
		return $this;
	}
	public function getAppId()
	{
		return Number::intNull($this->app_id);
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = Number::intNull($authfastId);
		return $this;
	}
	public function getAuthfastId()
	{
		return Number::intNull($this->authfast_id);
	}
	public function getPermissionLevelId()
	{
		return Number::intNull($this->permission_level_id);
	}
	public function setPermissionLevelId($permissionLevelId)
	{
		$this->permission_level_id = Number::intNull($permissionLevelId);

		return $this;
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'app_id' => $this->getAppId(),
			'authfast_id' => $this->getAuthfastId(),
			'permission_level_id' => $this->getPermissionLevelId(),
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
	 * @var PermissionLevelEntity
	 */
	private $permissionLevel;

	/**
	 * Get undocumented variable
	 *
	 * @return  PermissionLevelEntity
	 */
	public function getPermissionLevel()
	{
		if (is_null($this->permissionLevel)) {
			$this->permissionLevel = PermissionLevelRepository::byId($this->permission_level_id);
		}
		return $this->permissionLevel;
	}
}
