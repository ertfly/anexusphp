<?php

namespace AnexusPHP\Business\App\Entity;

use AnexusPHP\Business\Authfast\Entity\AuthfastEntity;
use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\DatabaseEntity;

class AppAuthfastEntity extends DatabaseEntity
{
	const TABLE = 'app_authfast';
	protected $id;
	protected $app_id;
	protected $authfast_id;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
	}
	public function setAppId($appId)
	{
		$this->app_id = $appId;
		return $this;
	}
	public function getAppId()
	{
		return $this->app_id;
	}
	public function setAuthfastId($authfastId)
	{
		$this->authfast_id = $authfastId;
		return $this;
	}
	public function getAuthfastId()
	{
		return $this->authfast_id;
	}
	public function toArray()
	{
		return array(
			'app_id' => $this->getAppId(),
			'authfast_id' => $this->getAuthfastId()
		);
	}

	/**
	 * Undocumented variable
	 *
	 * @var AuthfastEntity
	 */
	private $person;

	/**
	 * Undocumented function
	 *
	 * @param boolean $refresh
	 * @param string $cls
	 * @return AuthfastEntity
	 */
	public function getPerson($refresh = false, $cls = AuthfastEntity::class)
	{
		if (!$this->person || $refresh) {
			$this->person = AuthfastRepository::byId($this->authfast_id, $cls);
		}

		return $this->person;
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
