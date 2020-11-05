<?php

namespace AnexusPHP\Business\Permission\Entity;

use AnexusPHP\Core\DatabaseEntity;

class PermissionEventEntity extends DatabaseEntity
{
	const TABLE = 'permission_event';
	private $id;
	private $description;
	private $app;
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	public function getId()
	{
		return $this->id;
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
	public function setApp($app)
	{
		$this->app = $app;
		return $this;
	}
	public function getApp()
	{
		return $this->app;
	}
	public function toArray()
	{
		return array(
			'description' => $this->getDescription(),
			'app' => $this->getApp()
		);
	}
}
