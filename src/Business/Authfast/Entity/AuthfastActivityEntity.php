<?php

namespace AnexusPHP\Business\Authfast\Entity;

use AnexusPHP\Business\Authfast\Repository\AuthfastRepository;
use AnexusPHP\Core\DatabaseEntity;

class AuthfastActivityEntity extends DatabaseEntity
{
	const TABLE = 'authfast_activity';
	protected $id;
	protected $activity;
	protected $authfast_id;
	protected $module;
	protected $bind_id;
	protected $description;
	protected $created_at;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
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
		$this->authfast_id = $authfastId;
		return $this;
	}
	public function getAuthfastId()
	{
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
		$this->created_at = $createdAt;
		return $this;
	}
	public function getCreatedAt()
	{
		return $this->created_at;
	}
	public function toArray()
	{
		return array(
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
