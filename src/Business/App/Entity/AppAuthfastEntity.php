<?php

namespace PequiPHP\Business\App\Entity;

use PequiPHP\Business\Authfast\Entity\AuthfastEntity;
use PequiPHP\Business\Authfast\Repository\AuthfastRepository;
use PequiPHP\Core\MongoEntity;

class AppAuthfastEntity extends MongoEntity
{
	const TABLE = 'app_authfast';
	protected $_id;
	protected $app_id;
	protected $authfast_id;
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}
	public function getId()
	{
		if (!is_null($this->_id)) {
			$this->_id = intval($this->_id);
		}
		return $this->_id;
	}
	public function setAppId($appId)
	{
		$this->app_id = intval($appId);
		return $this;
	}
	public function getAppId()
	{
		if (!is_null($this->app_id)) {
			$this->app_id = intval($this->app_id);
		}
		return $this->app_id;
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
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
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
