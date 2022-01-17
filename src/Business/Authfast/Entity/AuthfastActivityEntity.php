<?php

namespace PequiPHP\Business\Authfast\Entity;

use PequiPHP\Business\Authfast\Repository\AuthfastRepository;
use PequiPHP\Core\MongoEntity;

class AuthfastActivityEntity extends MongoEntity
{
	const TABLE = 'authfast_activity';
	protected $_id;
	protected $activity;
	protected $authfast_id;
	protected $module;
	protected $bind_id;
	protected $description;
	protected $created_at;
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
	public function setActivity($activity)
	{
		$this->activity = $activity;
		return $this;
	}
	public function getActivity()
	{
		return $this->activity;
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
	public function setModule($module)
	{
		$this->module = $module;
		return $this;
	}
	public function getModule()
	{
		return $this->module;
	}
	public function setBindId($bindId)
	{
		$this->bind_id = $bindId;
		return $this;
	}
	public function getBindId()
	{
		return $this->bind_id;
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
	public function setCreatedAt($createdAt)
	{
		if (is_string($createdAt)) {
			$createdAt = strtotime($createdAt);
		}
		$this->created_at = intval($createdAt);
		return $this;
	}
	public function getCreatedAt()
	{
		if (is_null($this->created_at)) {
			$this->created_at = strtotime(date('Y-m-d H:i:s'));
		}

		if (is_string($this->created_at)) {
			$this->created_at = strtotime($this->created_at);
		}

		return intval($this->created_at);
	}
	public function toArray()
	{
		return array(
			'_id' => $this->getId(),
			'activity' => $this->getActivity(),
			'authfast_id' => $this->getAuthfastId(),
			'module' => $this->getModule(),
			'bind_id' => $this->getBindId(),
			'description' => $this->getDescription(),
			'created_at' => $this->getCreatedAt()
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
